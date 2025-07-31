<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
class Marketplace extends Model
{

    use LogsActivity;

    protected $fillable = ['name', 'url_pattern','class','has_commission','commission','minimum_profit_margin'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'marketplace_products')
            ->withPivot('external_url', 'active', 'rating', 'total_reviews', 'total_orders', 'html', 'last_scraped_at')
            ->withTimestamps();
    }

    public function productsmarketplaces()
    {
        return $this->belongsToMany(Product::class, 'product_prices')
            ->withPivot('price')  // Προσθήκη της τιμής στην pivot
            ->withTimestamps();
    }

    public function categoryMappings()
    {
        return $this->hasMany(CategoryMapping::class);
    }
}
