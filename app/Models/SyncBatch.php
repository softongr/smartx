<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncBatch extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'type', 'total_jobs', 'finished_jobs', 'status','duration_seconds','total_items','triggered_by','started_at'
    ];

    public function changes()
    {
        return $this->hasMany(SyncChange::class);
    }

    public function hasEntityChanges($type = null): bool
    {
        return $this->changes($type)->exists();
    }

    public function logs()
    {
        return $this->hasMany(SyncLog::class);
    }



}
