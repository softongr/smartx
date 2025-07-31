<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMarketplacePriceShop extends Model
{
    protected $fillable = ['product_marketplace_price_id', 'shop_id', 'shop_price', 'shop_url'];

    public function price()
    {
        return $this->belongsTo(ProductMarketplacePrice::class, 'product_marketplace_price_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
