<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use LogsActivity;


    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'city',
        'map_url',
        'postcode',
        'api',
        'api_type',
        'api_url',
        'unique_node',
        'xml_path'
    ];

    protected static function boot()
    {
        parent::boot(); // ✅ για να ενεργοποιούνται traits
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
