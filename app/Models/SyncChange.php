<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncChange extends Model
{
    protected $fillable = [
        'sync_batch_id',
        'entity_type',
        'external_id',
        'action',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
    //75256


    public function batch()
    {
        return $this->belongsTo(SyncBatch::class);
    }

}
