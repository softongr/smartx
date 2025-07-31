<?php

namespace App\Livewire\Catalog\Products\Monitors;

use App\Models\Marketplace;
use App\Models\MarketplaceProduct;
use App\Models\Product;
use Livewire\Component;

class Form extends Component
{
    public $object;
    public array $data = [];
    public function mount($product=null)
    {
        $this->object = Product::find($product);

        if (! $this->object || ! $this->object->prestashop_id) {
            abort(404);
        }
        $marketplaces = Marketplace::all();

        foreach ($marketplaces as $marketplace) {
            $mp = MarketplaceProduct::where('product_id',  $this->object->id)
                ->where('marketplace_id', $marketplace->id)
                ->first();
            $this->data[$marketplace->id] = [
                'url' => $mp->external_url ?? '',
                'safety_price' => $mp->safety_price ?? '',
            ];
        }
    }
    public function render()
    {
        return view('livewire.catalog.products.monitors.form',[
            'marketplaces' => Marketplace::all(),
        ]);
    }

    public function save()
    {
        // Δημιουργία κανόνων δυναμικά



        foreach ($this->data as $marketplaceId => $info) {

            $url = trim($info['url'] ?? '');
            $price = trim($info['safety_price'] ?? '');

            if (empty($url) && empty($price)) {
                continue;
            }

            $price = is_numeric($price) ? $price : null;


            if (empty($url) || empty($price)) {
                continue;
            }

            Product::updateOrCreate(
                [
                    'id' => $this->object->id,
                ],
                [
                    'monitor' => true,

                ]
            );

            MarketplaceProduct::updateOrCreate(
                [
                    'product_id' => $this->object->id,
                    'marketplace_id' => $marketplaceId,
                ],
                [
                    'external_url' => $info['url'] ?: null,
                    'safety_price' => $info['safety_price'] ?: null,
                ]
            );
        }

        session()->flash('success', 'Links saved successfully.');
    }
}
