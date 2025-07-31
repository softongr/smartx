<?php

namespace App\Models;

use App\ProductStep;
use App\Traits\FlushesSyncCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Traits\LogsActivity;
class Product extends Model
{   use FlushesSyncCache;
    use LogsActivity;
    protected $casts = [
        'step' => ProductStep::class,
    ];

    protected $fillable = [
        'name',
        'safety_price',
        'brand',
        'id_default_category',
        'reference',
        'marketplace_id',
        'scrape_link',
        'rate_vat_id',
        'mpn',
        'category',
        'ean',
        'desired_profit_margin',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'price',
        'partner_id',
        'features',
        'wholesale_price',
        'external_id',
        'link',
        'quantity',
        'html',
        'status',
        'active',
        'source_method',
        'step',
        'monitor',
        'data_hash',
        'date_add',
        'date_upd',
    ];

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function marketplaces() {
        return $this->belongsToMany(Marketplace::class, 'marketplace_products')
            ->withPivot('external_url', 'active', 'rating', 'total_reviews', 'total_orders', 'html', 'last_scraped_at')
            ->withTimestamps();
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function defaultImage()
    {
        return $this->hasOne(ProductImage::class)->where('default', true);
    }
    public function otherImages()
    {
        return $this->hasMany(ProductImage::class)->where('default', false);
    }

    public function getShopsWithPrices(): array
    {
        $results = [];

        // Φέρνουμε όλα τα marketplaceProducts με συσχετίσεις
        $marketplaceProducts = MarketplaceProduct::with([
            'marketplace',
            'prices.shops.shop'
        ])->where('product_id', $this->id)->get();

        foreach ($marketplaceProducts as $mp) {
            // Παίρνουμε την τελευταία τιμή ανά marketplace
            $latestPrice = $mp->prices->sortByDesc('scraped_at')->first();

            foreach ($latestPrice?->shops ?? [] as $shopPrice) {
                $results[] = [
                    'marketplace' => $mp->marketplace->name,
                    'shop' => $shopPrice->shop->name,
                    'price' => $shopPrice->shop_price,
                    'url' => $shopPrice->shop_url,
                    'scraped_at' => $latestPrice->scraped_at?->format('Y-m-d H:i'),
                ];
            }
        }
        usort($results, fn($a, $b) => $a['price'] <=> $b['price']);

        return $results;
    }


    public function getAverageRatingAttribute(): ?float
    {
        return $this->marketplaces
            ->pluck('pivot.rating')
            ->filter(fn($val) => is_numeric($val))
            ->avg();
    }

    public function getAverageReviewsAttribute(): ?float
    {
        return $this->marketplaces
            ->pluck('pivot.total_reviews')
            ->filter(fn($val) => is_numeric($val))
            ->avg();
    }

    public function getAverageOrdersAttribute(): ?float
    {
        return $this->marketplaces
            ->pluck('pivot.total_orders')
            ->filter(fn($val) => is_numeric($val))
            ->avg();
    }

    public function getAverageBoxAttribute()
    {

        return $this->marketplaces
            ->pluck('pivot.box_price')
           ;
    }


    public function monitors()
    {
        return $this->hasMany(MarketplaceProduct::class);
    }


    public function scrapeWithHelper(): ?array
    {
        $marketplace = $this->marketplace;


        if (!$marketplace || !class_exists($marketplace->class)) {
            return null;
        }

        try {
            $scraper = app($marketplace->class);


            if (!method_exists($scraper, 'scrape')) {

                return null;
            }

            return $scraper->scrape($this); // Περνάει το Product instance
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }


    public function rateVat()
    {
        return $this->belongsTo(RateVat::class, 'rate_vat_id');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function marketplacesprices()
    {
        return $this->belongsToMany(Marketplace::class, 'product_prices')
            ->withPivot('price', 'profit_margin','safety_price')
            ->withTimestamps();
    }


}
