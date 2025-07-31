<?php

namespace App\Models;

use App\Traits\FlushesSyncCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Carrier extends Model
{
    use FlushesSyncCache;
    protected $fillable = [
        'name',
        'external_id',
        'data_hash',
        'active'
    ];



}
