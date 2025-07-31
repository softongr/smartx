<?php

namespace App\Livewire\Shop;

use App\Models\Shop;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
class Index extends Component
{

    public $search;

    use WithPagination;
    use WithoutUrlPagination;

    public function render()
    {
        $items = Db::table('shops')
            ->leftJoin('product_marketplace_price_shops', 'shops.id', '=', 'product_marketplace_price_shops.shop_id')
            ->leftJoin('product_marketplace_prices', 'product_marketplace_price_shops.product_marketplace_price_id', '=', 'product_marketplace_prices.id')
            ->leftJoin('marketplace_products', 'product_marketplace_prices.marketplace_product_id', '=', 'marketplace_products.id')
            ->select('shops.id', 'shops.name', DB::raw('COUNT(DISTINCT marketplace_products.product_id) as product_count'))
            ->where('shops.name', 'LIKE', '%' . $this->search . '%')
            ->groupBy('shops.id', 'shops.name')
            ->orderByDesc('shops.id')
            ->paginate(10);

        return view('livewire.shop.index',[
            'items' => $items,
            'count' => Shop::all()->count(),
        ]);
    }
}
