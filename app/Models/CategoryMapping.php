<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'marketplace_id',
        'name',

    ];

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_mapping_category');
    }

}
