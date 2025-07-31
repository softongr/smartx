<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name'];

    public function priceShops()
    {
        return $this->hasMany(ProductMarketplacePriceShop::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductMarketplacePriceShop::class,
            'shop_id', // Από το ProductMarketplacePriceShop
            'id',      // Από το Product
            'id',      // Από το Shop
            'product_marketplace_price_id' // Foreign key στο ProductMarketplacePriceShop
        )
            ->join('product_marketplace_prices', 'product_marketplace_price_shops.product_marketplace_price_id', '=', 'product_marketplace_prices.id')
            ->join('marketplace_products', 'product_marketplace_prices.marketplace_product_id', '=', 'marketplace_products.id')
            ->select('marketplace_products.product_id')
            ->distinct('marketplace_products.product_id');
    }
}
