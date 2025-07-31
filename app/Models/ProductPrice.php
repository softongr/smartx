<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'marketplace_id',
        'price',
        'profit_margin',
        'safety_price'
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class);
    }
}
