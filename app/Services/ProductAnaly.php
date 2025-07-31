<?php

namespace App\Services;


use App\Models\CategoryMapping;
use App\Models\MarketplaceProduct;
use App\Models\Product;
use App\Models\ProductMarketplacePriceShop;
use App\Models\Setting;
use App\Models\Shop;
use App\ProductStep;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\True_;
use function Livewire\of;

class ProductAnaly
{


    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function handle(int $productId)
    {
        // Βρες το προϊόν από την βάση
        $this->product = Product::findOrFail($productId);
        $data = $this->analyzeProductHtml();

        if (!$data || !isset($data['name'])) {
            session()->flash('error', 'Δεν βρέθηκαν δεδομένα από το helper.');
            return redirect()->route('product.parser', ['product' => $this->product->id]);
        }

        $wholesalePrice = $this->product->wholesale_price;
      //  $marketplaceCommission = $this->product->marketplace->commission ?? 0;
        $vat = default_rate()->rate;
        $desiredNetProfitRate = Setting::get('default_minimum_profit',15);// 50
        $incomeTax = Setting::get('income_tax',20);

        $safe = app(CommercePricingToolkit::class)->calculateSafePrice($wholesalePrice, 0, $vat); //καταστήματος
        $target = CommercePricingToolkit::calculateTargetPrice($wholesalePrice, 55, 0, $vat, $incomeTax); // τιμη καταστήματος


        $prices = $this->product->marketplacesprices()->get()->toArray();

        if (count($prices)) {
            foreach ($prices as $item) {
                $price = CommercePricingToolkit::executeDynamicPricing($wholesalePrice,$item['commission'],
                    $vat,$incomeTax, $item['minimum_profit_margin'], $data['prices']);

                $safePriceMarketPlace =
                    app(CommercePricingToolkit::class)->calculateSafePrice($wholesalePrice, $item['commission'], $vat, 0);

                $this->product->marketplacesprices()->updateExistingPivot($item['id'], [
                    'price' => $price['finalPrice'],
                    'profit_margin' => $price['expectedNetProfitPercent'],
                    'safety_price' =>$safePriceMarketPlace
                ]);

            }
        }

        if ($idMarketPlace= $this->product->marketplace_id) {
            CategoryMapping::firstOrCreate([
                'marketplace_id' => $idMarketPlace,
                'name' => $data['category'],
            ]);
        }


        $product =  Product::updateOrCreate(
            ['id' => $productId],
            [
                'name'          => $data['name'],
                'mpn'           => $data['mpn'],
                'brand'         => $data['brand'],
                'features'      => json_encode($data['features']),
                'safety_price'  => $safe,
                'price'         => $target,
                'category' => $data['category'] ?? null,
            ]
        );

        if($product) {
            $this->images(
                $product,
                $data['images'] ?? [],
                $data['main_image'] ?? null
            );
            $mp = MarketplaceProduct::updateOrCreate(
                [
                    'product_id'        => $product->id,
                    'marketplace_id'    => $product->marketplace_id,
                ],
                [
                    'external_url'      => $product->scrape_link,
                    'rating'            => floatval($data['rating'] ?? 0),
                    'total_reviews'     => $data['total_reviews'] ?? 0,
                    'total_orders'      => $data['total_orders'] ?? 0,
                    'box_price'         => $data['box_price'] ?? 0,
                    'html'              => $product->html,
                    'last_scraped_at'   => Carbon::now(),
                ]
            );

            if ($data['prices']) {
                $min = collect($data['prices'] ?? [])->pluck('price')->map(function ($val) {
                    $val = str_replace(['.', ','], ['', '.'], trim($val));
                    return is_numeric($val) ? (float)$val : null;
                })->filter()->min();

                $price              = $mp->prices()->create([
                    'price'         => $min,
                    'shop_count'    => count($data['prices'] ?? []),
                    'review_count'  => $data['total_reviews'] ?? 0,
                    'rating'        => floatval($data['rating'] ?? 0),
                    'scraped_at'    => now(),
                ]);

                foreach ($data['prices'] ?? [] as $item) {

                    $converted = str_replace('.', '', $item['price']);      // '131424'
                    $converted = str_replace(',', '.', $converted); // '1314.24'
                    $shop = Shop::firstOrCreate(['name' => $item['shopName']]);
                    ProductMarketplacePriceShop::updateOrCreate([
                        'product_marketplace_price_id' => $price->id,
                        'shop_id' => $shop->id,
                    ], [
                        'shop_price' => $converted,
                        'shop_url' => $product->scrape_link ?? null,
                    ]);
                }
            }

            $product->update(['step' => ProductStep::Pricing]);
            return true;
        }
        return false;
    }


    public function analyzeProductHtml()
    {


        $marketplace = $this->product->marketplace;
        if (!$marketplace || !class_exists($marketplace->class)) {

              return null;
        }

        try {


            $html = $this->product->html;
            if (!$html) {
                 return null;
            }

            $scraperClass = $marketplace->class;
            if (!class_exists($scraperClass)) {
                 return null;
            }

            $scraper = app($scraperClass);

            if (!method_exists($scraper, 'scrape')) {
                  return null;
            }

            $data = $scraper->scrape($this->product); // Κλήση της scrape μεθόδου

            return $data;
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    public  function images(Product $product, array $urls, ?string $mainUrl = null): array
    {
        $saved = [];

        // αν δεν είναι μέσα το main, βάλτο στην αρχή
        if ($mainUrl && !in_array($mainUrl, $urls)) {
            array_unshift($urls, $mainUrl);
        }

        foreach ($urls as $index => $url) {
            if (!$url) continue;

            $isMain = ($url === $mainUrl);
            $urlHash = md5($url);

            if ($product->images()->where('url_hash', $urlHash)->exists()) {
                continue;
            }

            $imageContent = @file_get_contents($url);
            if ($imageContent === false) continue;

            $contentHash = sha1($imageContent);
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = $product->id . '_' . ($isMain ? 'main' : $index) . '.' . $extension;
            $path = 'images/' . $product->id . '/' . $filename;

            Storage::disk('public')->put($path, $imageContent);
            $localPath = Storage::url($path);

            $product->images()->create([
                'image_path'    => $url,
                'image'         => $localPath,
                'filename'      => $filename,
                'mime_type'     => Storage::disk('public')->mimeType($path),
                'size'          => Storage::disk('public')->size($path),
                'default'       => $isMain,
                'url_hash'      => $urlHash,
                'content_hash'  => $contentHash,
            ]);

            $saved[] = [
                'url' => $url,
                'url_hash' => $urlHash,
                'content_hash' => $contentHash,
                'filename' => $filename,
            ];
        }

        return [
            'total_saved' => count($saved),
            'images' => $saved,
        ];
    }

}
