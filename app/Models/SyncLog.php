<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $fillable = [
        'sync_batch_id',
        'entity_type',
        'message',
        'context',
        'level'
    ];

    protected $casts = [
        'context' => 'array',
    ];

    public static function info(string $message, ?int $batchId = null, ?string $entity = null, array $context = []): void
    {
        self::create([
            'sync_batch_id' => $batchId,
            'entity_type'   => $entity,
            'level'         => 'info',
            'message'       => $message,
            'context'       => $context,
        ]);
    }


    public static function warning(string $message, ?int $batchId = null, ?string $entity = null, array $context = []): void
    {
        self::create([
            'sync_batch_id' => $batchId,
            'entity_type'   => $entity,
            'level'         => 'warning',
            'message'       => $message,
            'context'       => $context,
        ]);
    }

    public static function error(string $message, ?int $batchId = null, ?string $entity = null, array $context = []): void
    {
        self::create([
            'sync_batch_id' => $batchId,
            'entity_type'   => $entity,
            'level'         => 'error',
            'message'       => $message,
            'context'       => $context,
        ]);
    }

    public function batch()
    {
        return $this->belongsTo(SyncBatch::class, 'sync_batch_id');
    }

}
