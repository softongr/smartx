<?php

namespace App\Livewire\Catalog\Products;

use App\Jobs\DownloadProductHtmlJob;
use App\Models\Category;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\RateVat;
use App\Models\Setting;
use App\Models\Supplier;
use App\ProductStep;
use App\Services\ProductHtmlDownloader;
use App\Services\RemoteHtmlClient;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Form extends Component
{

    public $id;
    public $id_default_category;
    public $marketplace_id=null;
    public $scrape_link ;
    public $ean;
    public $object;
    public $quantity=0;
    public $wholesale_price;


    public $isEdit=false;
    public $rate_vat_id;
    public $marketplaces;
    public $availableRates =[];
    public $income_tax;
    public $default_minimum_profit;

    public function mount($product = null)
    {



        $this->quantity = (Setting::get('default_quantity')) ? Setting::get('default_quantity') : 0;
        $this->income_tax = (Setting::get('income_tax')) ? Setting::get('income_tax') : 0;
        $this->default_minimum_profit = (Setting::get('default_minimum_profit')) ? Setting::get('default_minimum_profit') : 0;
        $this->availableRates = RateVat::orderByDesc('default')->get()->toArray();
        $this->rate_vat_id = $this->object->rate_vat_id ?? RateVat::where('default', true)->value('id');
        $this->marketplace_id = $this->object->marketplace_id ?? Setting::get('default_marketplace_for_add_product', false);
        if ($product) {
            $this->object                   = Product::findOrFail($product);

            if ($this->object->step !=  ProductStep::Scrape) {
                session()->flash('error', __('You cannot edit this product. It is already processed.'));
                return redirect()->route('products.index');
            }

            $this->marketplace_id            = $this->object->marketplace_id;
            $this->id                       = $this->object->id;
            $this->wholesale_price         = $this->object->wholesale_price;
            $this->quantity                = $this->object->quantity;
            $this->ean                      = $this->object->ean;
            $this->scrape_link      = $this->object->scrape_link;
            $this->rate_vat_id  = $this->object->rate_vat_id;
            $this->isEdit                   = true;
        }

        $this->marketplaces                 = Marketplace::all();
    }


    public function render()
    {
        return view('livewire.catalog.products.form');
    }


    public function save()
    {
        $rules = [
            'quantity'        => 'required|integer',
            'ean'             => 'nullable|string',
            'scrape_link'     => ['required', 'url'],
            'wholesale_price' => ['required', 'gt:0', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'marketplace_id'  => ['required', 'integer', 'not_in:0'],
        ];

        $this->validate($rules);
        $scrapeLinkExists = Product::where('scrape_link', $this->scrape_link)
            ->when($this->isEdit, fn($query) => $query->where('id', '!=', $this->id))
            ->exists();

        if ($scrapeLinkExists) {
            $this->addError('scrape_link', __('This link already exists in the database.'));
            return;
        }

        if (!empty($this->ean)) {
            $eanExists = Product::where('ean', $this->ean)
                ->whereNull('external_id')
                ->when($this->isEdit, fn($query) => $query->where('id', '!=', $this->id))
                ->exists();
            if ($eanExists) {
                $this->addError('ean', __('A product with this EAN already exists'));
                return;
            }
        }

        $fields = [
            'scrape_link'          => $this->scrape_link,
            'quantity'             => $this->quantity,
            'ean'                  => $this->ean,
            'marketplace_id'       => $this->marketplace_id,
            'wholesale_price'      => $this->wholesale_price,
            'source_method'        =>'scrape',
            'status'               => 'pending',
            'rate_vat_id'         => $this->rate_vat_id
        ];

        if ($this->isEdit) {
            $product = Product::findOrFail($this->id);
            $product->fill($fields);
            $product->save();
        }else{
            $product = new Product();
            $product->fill($fields);
            $product->save();
        }

        $activeMarketplaces = Marketplace::where('has_commission', true)->get();

        $marketplacesData = $activeMarketplaces->mapWithKeys(function ($marketplace) {
            return [
                $marketplace->id => [
                    'price' => 0,
                    'profit_margin'=>0,
                    'safety_price' => null
                ]
            ];
        });


        $product->marketplacesprices()->sync($marketplacesData);

//        if ($product){
//            Bus::batch(new DownloadProductHtmlJob($product->id))->onQueue('scraping')->dispatch();
//        }


        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));


        return redirect()->route('product.create');
    }

    public function getDisableSaveButtonProperty()
    {
        return $this->income_tax <= 0 || $this->default_minimum_profit <= 0;

    }
}
