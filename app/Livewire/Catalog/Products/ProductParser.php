<?php

namespace App\Livewire\Catalog\Products;
use App\Helpers\CategoryMappingHelper;
use App\Jobs\DownloadProductHtmlJob;
use App\Models\Category;
use App\Models\OpenaiPrompt;
use App\Models\RateVat;
use App\Models\SyncLog;
use App\Services\CommercePricingToolkit;
use App\Services\ProductAnaly;
use App\Services\ProductHtmlDownloader;
use App\Services\RemoteHtmlClient;
use App\Services\ShopApiService;
use Illuminate\Support\Facades\Bus;
use OpenAI;

use App\Models\MarketplaceProduct;
use App\Models\Product;
use App\Models\ProductMarketplacePrice;
use App\Models\ProductMarketplacePriceShop;
use App\Models\Setting;
use App\Models\Shop;
use App\ProductStep;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use PHPHtmlParser\Dom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductParser extends Component
{
    public bool $forceLoading = false;

    public $id;
    public $object;
    public ?float $price = 0;
    public ?float $skroutz_price = 0;


    public $image =null;


    public ?float $wholesale_price=0;

    public array $shopPrices = [];
    public array $features = [];

    use WithPagination;
    use WithoutUrlPagination;
    public ProductStep $step;
    public $minShop=0;
    public $marketplacesPrices;

    public $last_scraped_at;
    public $price_box =0;

    public $marketplace;

    public $checkCategoryMapper;


    public function mount($product)
    {
        $this->id = $product;
        $this->object = Product::find($this->id);
        if (!$this->object) {
            abort(404, 'Product not found');
        }

        if (!$this->object) {
            $this->checkCategoryMapper = false;
            $this->marketplace = null;
            $this->marketplacesPrices = [];
            $this->minShop = [];
            $this->last_scraped_at = null;
            $this->price_box = 0;
            $this->image = null;
            $this->shopPrices = [];
            $this->price = 0;
            $this->wholesale_price = 0;
            $this->features = [];
            return;
        }


        $this->checkCategoryMapper = !CategoryMappingHelper::allCategoryMappingsHaveCategories();

        $this->marketplace = $this->object->marketplace ?? null;
        $this->marketplacesPrices = $this->object->marketplacesprices()->withPivot('price')->get() ?? [];
        // Shops with lowest price
        $this->minShop = ProductMarketplacePrice::with(['priceShops.shop'])
            ->whereHas('marketplaceProduct', fn($q) => $q->where('product_id', $this->id))
            ->get()
            ->flatMap(function ($price) {
                return $price->priceShops->map(function ($ps) use ($price) {
                    return [
                        'shop_name'   => $ps->shop->name ?? '-',
                        'shop_price'  => $ps->shop_price,
                        'shop_url'    => $ps->shop_url,
                        'scraped_at'  => $price->scraped_at,
                    ];
                });
            })
            ->sortBy('shop_price')
            ->first() ?? null;

        $this->last_scraped_at = MarketplaceProduct::where('product_id', $this->object->id)
            ->where('marketplace_id', $this->object->marketplace_id)
            ->value('last_scraped_at') ?? null;


        $this->price_box = MarketplaceProduct::where('product_id', $this->object->id)
            ->where('marketplace_id', $this->object->marketplace_id)
            ->value('box_price') ?? 0;

        // Image
        $raw = trim($this->object->defaultImage->image ?? '');
        $clean = Str::replaceFirst('/storage/', '', $raw);
        $this->image = $clean ? Storage::url($clean) : null;

        $this->loadShopPrices();

        // Prices
        $this->price = $this->object->price ?? 0;
        $this->wholesale_price = $this->object->wholesale_price ?? 0;

        $this->features = json_decode($this->object->features, true) ?? [];



    }

    public function setStep(ProductStep $step)
    {
        $this->object->update(['step' => $step]);
        $this->step = $step;
    }

    public function render()
    {


        return view('livewire.catalog.products.product-parser');
    }




    public function loadShopPrices()
    {
        $this->shopPrices = Product::find($this->id)?->getShopsWithPrices() ?? [];

    }












    public function savePrices()
    {

        $rules = [
            'price' => ['required', 'gt:0', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'wholesale_price' => ['required', 'gt:0', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
        ];


        $this->validate($rules);

        if ($this->wholesale_price > $this->price) {
            $this->addError('wholesale_price', __('Η χονδρική τιμή δεν μπορεί να είναι μεγαλύτερη από την τελική τιμή.'));
            return;
        }

        $product =  Product::updateOrCreate(
            ['id' => $this->id],
            [
                'price' => $this->price,
                'skroutz_price'        => (!$this->skroutz_price) ? $this->price : $this->skroutz_price,
                'shopflix_price'       => (!$this->shopflix_price) ? $this->price : $this->shopflix_price,
                'public_price'         => (!$this->public_price) ? $this->price : $this->public_price,
                'wolt_price'           => (!$this->wolt_price) ? $this->price : $this->wolt_price,
                'wholesale_price'      => $this->wholesale_price,


            ]
        );
        $this->setStep(ProductStep::Shop);
        session()->flash('success', __('Saved'));


     //   return redirect()->route('product.parser', ['product' => $product->id]);
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

    public function toShop()
    {
        $shopServiceApi = new ShopApiService();
        $object = $this->object;
        $otherImages = $object->otherImages;

        $imageUrls = $otherImages->map(function ($image) {
            return asset($image->image); // ή $image->url, ανάλογα το πεδίο
        })->values()->all();
        $payload = [
            'type' => 'product',
            'item' => [
                'id_source'           => $object->id ?? null,
                'external_id'         => 0,
                'name'                => $object->name ?? null,
                'short_description'   => $object->short_description ?? '',
                'description'         => $object->description ?? '',
                'meta_title'          => $object->meta_title ?? '',
                'meta_description'    => $object->meta_description ?? '',
                'quantity'            => $object->quantity ?? 0,
                'mpn'                 => $object->mpn ?? null,
                'ean13'               => $object->ean ?? null,
                'price'               => $object->price ?? 0,
                'wholesale_price'     => $object->wholesale_price ?? 0,
                'skroutz_price'       => $object->skroutz_price ?? null,
                'shopflix_price'      => $object->shopflix_price ?? null,
                'bestprice_price'     => $object->bestprice_price ?? 0,
                'wolt_price'          => $object->wolt_price ?? null,
                'reference'           => $object->reference ?? null,
                'active'              => $object->active ?? 0,
//                'id_category_default' => $object->id_category_default ?? 2,
                'brand'               => $object->brand ?? null,
                'image' => asset( ltrim($object->defaultImage->image, '/')),
                'categories'          => $object['item']['categories'] ?? [],
                //'images'              => $imageUrls ?? [],
                'features'            => json_decode($object->features) ?? [],
            ]
        ];

        $res = $shopServiceApi->send($payload);
        if ($res['data']['external_id'] && isset($res['data']['external_id'])) {
            $object->external_id = $res['data']['external_id'];
            $object->status = 'completed';
            $object->step = ProductStep::Completed;
            $object->save();

            $updatedAfter = last_completed_sync_time('products');
            $mechanism = app(\App\Services\SyncMechanism::class);
            $batch = $mechanism->run('product', $updatedAfter, 'manual');
            if ($batch){
                return redirect()->route('synchronization');
            }
        }
    }





}


