<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketplaceProduct extends Model
{
    protected $casts = [
    'last_scraped_at' => 'datetime',
];
    protected $table = 'marketplace_products';
    protected $fillable = ['product_id', 'marketplace_id', 'external_url', 'active',
        'rating', 'total_reviews', 'total_orders','html','last_scraped_at','safety_price','box_price','price_difference'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductMarketplacePrice::class);
    }
}
