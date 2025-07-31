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

class ProductParser1 extends Component
{
    public bool $forceLoading = false;

    public $id;
    public $object;
    public ?float $price = 0;
    public ?float $skroutz_price = 0;
    public $openai_auto_apply_prompts = false;
    public ?float $shopflix_price = 0;
    public $image =null;
    public ?float $public_price = 0;
    public ?float $wolt_price = 0;

    public ?float $wholesale_price=0;

    public $meta_title=null;
    public $meta_description=null;
    public $short_description=null;
    public $description=null;
    public array $shopPrices = [];
    public array $features = [];

    public $jobStatus = 'pending';  // Αρχική κατάσταση του job
    public $progress = 0;  // Αρχική πρόοδος
    protected $listeners = ['job-status-updated' => 'onJobStatusUpdated'];

    use WithPagination;
    use WithoutUrlPagination;
    public ProductStep $step;
    public $minShop=0;
    public $marketplacesPrices;

    public $last_scraped_at;
    public $price_box =0;


    // Μέθοδος που θα ενημερώσει το jobStatus και την πρόοδο
    public function onJobStatusUpdated($eventData)
    {
        $this->jobStatus = $eventData['status'];  // Ενημερώνουμε το jobStatus
        $this->progress = $eventData['progress'];  // Ενημερώνουμε την πρόοδο
    }
    public function mount($product)
    {
        $this->id = $product;
        $this->object = Product::find($this->id);
        $this->openai_auto_apply_prompts = (bool) Setting::get('openai_auto_apply_prompts', false);
        if (!$this->object) {
            abort(404, 'Product not found');
        }


        $this->step = $this->object->step;
        if ($this->step === ProductStep::Scrape) {
            $this->features = [];
        } elseif ($this->step === ProductStep::Parse) {
            $this->last_scraped_at = MarketplaceProduct::where('product_id', $this->object->id)
                ->where('marketplace_id', $this->object->marketplace_id)
                ->value('last_scraped_at');
            $this->wholesale_price = $this->object->wholesale_price;
        } elseif ($this->step === ProductStep::Pricing) {

            $this->marketplacesPrices =  $this->object->marketplacesprices()->withPivot('price')->get();

            $productId  = $this->object->id;

            $this->minShop = ProductMarketplacePrice::with(['priceShops.shop'])
                ->whereHas('marketplaceProduct', fn($q) => $q->where('product_id', $productId))
                ->get()
                ->flatMap(function ($price) {
                    return $price->priceShops->map(function ($ps) use ($price) {
                        return [
                            'shop_name' => $ps->shop->name ?? '-',
                            'shop_price' => $ps->shop_price,
                            'shop_url' => $ps->shop_url,
                            'scraped_at' => $price->scraped_at,
                        ];
                    });
                })
                ->sortBy('shop_price')
                ->first();
            $this->last_scraped_at = MarketplaceProduct::where('product_id', $this->object->id)
                ->where('marketplace_id', $this->object->marketplace_id)
                ->value('last_scraped_at');
            $this->price_box = MarketplaceProduct::where('product_id', $this->object->id)
                ->where('marketplace_id', $this->object->marketplace_id)
                ->value('box_price');
            $raw = trim($this->object->defaultImage->image ?? '');

            $clean = Str::replaceFirst('/storage/', '', $raw);
            $this->image = Storage::url($clean);
            $this->loadShopPrices();

            $this->price = $this->object->price ?? 0;
            $this->skroutz_price = $this->object->skroutz_price ?? 0;
            $this->public_price = $this->object->public_price ?? 0;
            $this->wolt_price = $this->object->wolt_price ?? 0;
            $this->shopflix_price = $this->object->shopflix_price ?? 0;
            $this->wholesale_price  = $this->object->wholesale_price ?? 0;
            $this->features = json_decode($this->object->features, true);

        }elseif ($this->step === ProductStep::OpenAI) {
            $raw = trim($this->object->defaultImage->image ?? '');

            $this->meta_title = $this->object->meta_title ?? '';
            $this->meta_description = $this->object->meta_description ?? '';
            $this->short_description = $this->object->short_description ?? '';
            $this->description = $this->object->description ?? '';

            $clean = Str::replaceFirst('/storage/', '', $raw);
            $this->last_scraped_at = MarketplaceProduct::where('product_id', $this->object->id)
                ->where('marketplace_id', $this->object->marketplace_id)
                ->value('last_scraped_at');
            $clean = Str::replaceFirst('/storage/', '', $raw);
            $this->image = Storage::url($clean);
        }elseif ($this->step === ProductStep::Shop) {

        }
    }

    public function setStep(ProductStep $step)
    {
        $this->object->update(['step' => $step]);
        $this->step = $step;
    }

    public function render()
    {


        return view('livewire.catalog.products.product-parser',[

        ]);
    }



    public function save()
    {




        $scrapingService = new ProductAnaly($this->object);
        $product = $scrapingService->handle($this->object->id);





        if ($product){
            $this->setStep(ProductStep::OpenAI);
            $this->object = $product;
            $this->loadShopPrices();
            $this->forceLoading = true;


            return redirect()->route('product.create');
            //return redirect()->route('product.parser', ['product' => $this->object->id]);
        }








    }
    public function loadShopPrices()
    {
        $this->shopPrices = Product::find($this->id)?->getShopsWithPrices() ?? [];

    }
    public function parseNumber($value): float {
        return floatval(str_replace(',', '.', $value ?? 0));
    }

    public function getPrices($prices)
    {
        $prices = array_column($prices, 'price');
        $cleaned = array_map(function ($value) {
            return floatval(str_replace(',', '.', trim($value)));
        }, $prices);

        return min($cleaned);
    }




    public function saveDOMHTMLtoDatabase(RemoteHtmlClient $htmlClient)
    {


        $link = $this->object->scrape_link;
        $download = new ProductHtmlDownloader($htmlClient);
       $d=  $download->handle($this->object->id);

dd($d);

        $products = Product::query()
            ->whereNotNull('scrape_link')
            ->whereNull('html')
            ->limit(3)
            ->get();


        $batch = Bus::batch(
            $products->map(fn($product) => new DownloadProductHtmlJob($product->id))
        )->onQueue('scraping')->dispatch();

        $this->setStep(ProductStep::Parse);
        $this->dispatch('forceRedirect');
    }
    public function resetWizard()
    {
        $this->deletePrices(); // καθαρίζει όλα τα marketplace + τιμές
        $this->setStep(ProductStep::Scrape);
        $this->object->update([
            'name' => null,
            'html' => null,
            'status' => 'pending',
            'price' => null,
            'public_price' => null,
            'shopflix_price' => null,
            'skroutz_price' => null,
            'wolt_price' => null,
        ]);


        $this->step = ProductStep::Scrape;
        $this->price = null;
        $this->public_price = null;
        $this->shopflix_price = null;
        $this->skroutz_price = null;
        $this->wolt_price = null;
        $this->shopPrices = [];

        session()->flash('success', 'Το προϊόν επανήλθε στο αρχικό βήμα.');
    }


    public function deletePrices()
    {
        $productId = $this->object->id;

        // Πρώτα βρίσκουμε τα marketplace_product IDs του προϊόντος
        $mpIds = MarketplaceProduct::where('product_id', $productId)->pluck('id');

        // Διαγράφουμε πρώτα τα καταστήματα ανά τιμή
       ProductMarketplacePriceShop::whereIn(
            'product_marketplace_price_id',
           ProductMarketplacePrice::whereIn('marketplace_product_id', $mpIds)->pluck('id')
        )->delete();

        // Μετά διαγράφουμε τις τιμές
      ProductMarketplacePrice::whereIn('marketplace_product_id', $mpIds)->delete();

        // Τέλος διαγράφουμε τις σχέσεις του προϊόντος με τα marketplace
        MarketplaceProduct::where('product_id', $productId)->delete();

        session()->flash('success', 'Όλες οι τιμές και οι σχέσεις marketplace διαγράφηκαν.');
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


    public function saveDetails()
    {
        $apiKey = Setting::get('openai_api_key');
        $orgId  = Setting::get('openai_organization');

        if (!$apiKey) {
            $this->addError('error', 'Το OpenAI API Key δεν έχει οριστεί.');
            return;
        }


        $client = OpenAI::factory()
            ->withApiKey(Setting::get('openai_api_key'))
            ->withOrganization(Setting::get('openai_organization'))
            ->make();
        //test

        $promptMapping = json_decode(Setting::get('openai_product_prompt_field_mapping', '{}'), true);

        if (!isset($this->object)) {
            throw new \Exception('Το προϊόν δεν έχει οριστεί.');
        }



        if ($this->openai_auto_apply_prompts)
        {




        foreach ($promptMapping as $promptId => $productField) {
            $prompt = OpenaiPrompt::find($promptId);

            if (!$prompt || !$productField) continue;

            // Δημιουργία prompt με αντικατάσταση μεταβλητών
            $userContent = $this->buildPromptContent($prompt->user_prompt_template, $this->object);



            $response = $client->chat()->create([
                'model' => Setting::get('openai_model', 'gpt-4o'),
                'messages' => [
                    ['role' => 'system', 'content' => $prompt->system_prompt],
                    ['role' => 'user', 'content' => $userContent],
                ],
                'temperature' => (float) Setting::get('openai_temperature', 0.7),
                'max_tokens' => (int) Setting::get('openai_max_tokens', 1024),
            ]);

            $output = trim($response->choices[0]->message->content ?? '');
            $this->object->{$productField} = $output;


        }

            $this->object->save();

            $this->meta_title = $this->object->meta_title ?? '';
            $this->meta_description = $this->object->meta_description ?? '';
            $this->short_description = $this->object->short_description ?? '';
            $this->description = $this->object->description ?? '';

        }


        $this->setStep(ProductStep::Pricing);
    }


    protected function buildPromptContent(string $template, $product): string
    {
        $replacements = [
            '{{name}}' => $product->name,
            '{{features}}' => $product->features,
            '{{meta_title}}' => $product->meta_title,
            '{{meta_description}}' => $product->meta_description,
            '{{description}}' => $product->description,
            '{{description_short}}' => $product->short_description,
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    public function togglePromptSetting()
    {

        $this->openai_auto_apply_prompts = $this->openai_auto_apply_prompts;

    }

    public function generateField($field)
    {
        $mapping = json_decode(Setting::get('openai_product_prompt_field_mapping', '{}'), true);

        // Ανάποδο lookup: βρες το prompt_id που αντιστοιχεί στο πεδίο
        $promptId = array_search($field, $mapping);


        if (!$promptId) {
            $this->addError($field, __('No prompt assigned.'));
            return;
        }


        $prompt = OpenaiPrompt::find($promptId);
        if (!$prompt) {
            $this->addError($field, 'Prompt not found.');
            return;
        }

        $apiKey = Setting::get('openai_api_key');

        if (!$apiKey) {
            $this->addError($field, 'Το OpenAI API Key λείπει. Πήγαινε στις ρυθμίσεις και συμπλήρωσέ το.');
            return;
        }


        $client = \OpenAI::factory()
            ->withApiKey(Setting::get('openai_api_key'))
            ->withOrganization(Setting::get('openai_organization'))
            ->make();

        $userContent = $this->buildPromptContent($prompt->user_prompt_template, $this->object);

        $response = $client->chat()->create([
            'model' => Setting::get('openai_model', 'gpt-4o'),
            'messages' => [
                ['role' => 'system', 'content' => $prompt->system_prompt],
                ['role' => 'user', 'content' => $userContent],
            ],
            'temperature' => (float) Setting::get('openai_temperature', 0.7),
            'max_tokens' => (int) Setting::get('openai_max_tokens', 1024),
        ]);

        $output = trim($response->choices[0]->message->content ?? '');
//DnGj6fRyyyW6D7!
        $this->$field = $output;

//        $this->object->$field = $output;
//        $this->object->save(); // Αποθήκευση στη βάση

        session()->flash('success', ucfirst($field) . ' generated and saved.');

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

    public function calculateMinimumRetailPrice(
        float $wholesalePrice,
        float $vatPercent = 24.0,
        float $commissionPercent = 13.0,
        float $taxPercent = 20.0
    ): float {
        // Στόχος: να μείνουν όσα είναι η χονδρική τιμή (ή το καθαρό σου κόστος)
        $targetNetAfterTax = $wholesalePrice;

        // Υπολογίζουμε πόσο πρέπει να είναι πριν τον φόρο για να μείνουν 10€
        $netBeforeTax = $targetNetAfterTax / (1 - ($taxPercent / 100));

        // Υπολογίζουμε πόσο πρέπει να είναι πριν την προμήθεια
        $netBeforeCommission = $netBeforeTax / (1 - ($commissionPercent / 100));

        // Τελική τιμή με ΦΠΑ
        $vatMultiplier = 1 + ($vatPercent / 100);
        $retailPriceWithVat = $netBeforeCommission * $vatMultiplier;

        return round($retailPriceWithVat, 2);
    }



}


