<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMarketplacePrice extends Model
{
    protected $casts = [
        'scraped_at' => 'datetime',
    ];

    protected $fillable = ['marketplace_product_id', 'price', 'shop_count', 'review_count', 'rating', 'scraped_at'];
    public function marketplaceProduct()
    {
        return $this->belongsTo(MarketplaceProduct::class);
    }

    public function shops()
    {
        return $this->hasMany(ProductMarketplacePriceShop::class);
    }

    public function priceShops()
    {
        return $this->hasMany(ProductMarketplacePriceShop::class);
    }

}
