<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'default','image','filename','mime_type','size',    'url_hash',
        'content_hash'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
