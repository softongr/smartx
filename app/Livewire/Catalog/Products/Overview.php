<?php

namespace App\Livewire\Catalog\Products;

use App\Helpers\CategoryMappingHelper;
use App\Livewire\OpenAi\Mapper\Category;
use App\Models\CategoryMapping;
use App\Models\Marketplace;
use App\Models\MarketplaceProduct;
use App\Models\Product;
use App\Models\ProductMarketplacePrice;
use App\Models\Setting;
use App\ProductStep;
use App\Services\CommercePricingToolkit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use function Pest\Laravel\put;

class Overview extends Component
{

    public $id;
    public $object;
    public ?float$price=0;

    public array $prices = []; // Dynamic marketplace prices

    public ?float $wholesale_price=0;
    public $image =null;
    public array $features= [];
    public array $shopPrices= [];
    public $last_scraped_at;
    public $checkCategoryMapper = false;
    public ProductStep $step;
    public $marketplace;
    public $minShop=0;
    public $marketplacesPrices=[];
    public $price_box=0;

    public function mount($product)
    {
        $this->id = $product;
        $this->object = Product::find($this->id);
        if (!$this->object) {
            abort(404, 'Product not found');
        }

        if ($this->object->step != ProductStep::Pricing){
            abort(404, 'Product not found');

        }

        $this->marketplace = $this->object->marketplace ?? null;
        $this->last_scraped_at = MarketplaceProduct::where('product_id', $this->object->id)
            ->where('marketplace_id', $this->object->marketplace_id)
            ->value('last_scraped_at') ?? null;
        $this->marketplacesPrices = $this->object->marketplacesprices()->withPivot('price')->get() ?? [];


        foreach ($this->marketplacesPrices as $mp) {
            $this->prices[$mp->id] = [
                'price' => $mp->pivot->price,
                'profit_margin' => $mp->pivot->profit_margin,
                'safety_price' => $mp->pivot->safety_price,
            ];
        }
        $this->checkCategoryMapper = !CategoryMappingHelper::allCategoryMappingsHaveCategories();
         $this->price_box = MarketplaceProduct::where('product_id', $this->object->id)
            ->where('marketplace_id', $this->object->marketplace_id)
            ->value('box_price') ?? 0;



        $raw = trim($this->object->defaultImage->image ?? '');
        $clean = Str::replaceFirst('/storage/', '', $raw);
        $this->image = $clean ? Storage::url($clean) : null;

        $this->loadShopPrices();

        $this->price = $this->object->price ?? 0;
        $this->wholesale_price = $this->object->wholesale_price ?? 0;
        $this->features = json_decode($this->object->features, true) ?? [];
        $this->minShop  = ProductMarketplacePrice::with(['priceShops.shop'])
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
    }
    public function render()
    {
        return view('livewire.catalog.products.overview');
    }





    public function loadShopPrices()
    {
        $this->shopPrices = Product::find($this->id)?->getShopsWithPrices() ?? [];

    }

    public function save()
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

        foreach ($this->prices as $marketplaceId => $data) {


            $this->object->marketplacesprices()->updateExistingPivot($marketplaceId, [
                'price' => $data['price'],
                'profit_margin' => 0,
            ]);

        }

        $mappingName = $this->object->category;
        $externalIds = $this->getExternalCategoryIdsFromMappingName($mappingName, $this->marketplace->id);
        $categoryIds = \App\Models\Category::whereIn('external_id', $externalIds)->pluck('id')->all();



        $product =  Product::updateOrCreate(
            ['id' => $this->id],
            [
                'price'          => $this->price,
                'status'         => 'platform',
                'id_default_category'  => end($externalIds)
        ]
        );
        $product->categories()->sync($categoryIds);


        $filteredIds = Product::where('status', 'pending')
            ->where('step', ProductStep::Pricing)
            ->where('id', '!=', $this->id) // Εξαιρούμε το τρέχον
            ->orderBy('id')
            ->pluck('id');


        $nextId = $filteredIds->first(fn($id) => $id > $this->id);

        $nextId = $nextId ?? $filteredIds->first();

        if ($nextId) {
            return redirect()->route('product.parser', ['product' => $nextId]);
        }else {
            return redirect()->route('products.index');
        }
    }

    public function getExternalCategoryIdsFromMappingName(string $mappingName,  int $marketplaceId): array
    {
        $mapping = CategoryMapping::where('name', $mappingName)
            ->where('marketplace_id', $marketplaceId)
            ->first();

        if (!$mapping) {
            return [];
        }
        $externalIds = [];

        if ($mapping && $mapping->categories->isNotEmpty()) {
            foreach ($mapping->categories as $category) {

                if (!is_null($category->external_id)) {
                    $externalIds[] = $category->external_id;
                }
            }
        }

        return $externalIds;
    }

}
