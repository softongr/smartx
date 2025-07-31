<?php

namespace App\Models;

use App\Traits\FlushesSyncCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;




class Category extends Model
{

    use FlushesSyncCache, NodeTrait;
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'external_id',
        'parent_id',
        'description',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'link',
        'data_hash',
        'active',
        'date_add',
        'date_upd',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }



    public function categoryMappings()
    {
        return $this->belongsToMany(
            \App\Models\CategoryMapping::class,
            'category_mapping_category', // pivot table
            'category_id',               // foreign key στο current model (Category)
            'category_mapping_id'        // foreign key στο related model
        );
    }
}
