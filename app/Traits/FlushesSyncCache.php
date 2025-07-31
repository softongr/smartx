<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait FlushesSyncCache
{
    protected static function bootFlushesSyncCache(): void
    {
        $type = self::getSyncType();

        static::created(fn() => self::flushSyncCache($type));
        static::updated(fn() => self::flushSyncCache($type));
        static::deleted(fn() => self::flushSyncCache($type));
    }

    protected static function flushSyncCache(string $type): void
    {
        Cache::forget("sync_count_{$type}");
        Cache::forget("sync_new_today_{$type}");
        Cache::forget("sync_new_since_{$type}");
        Cache::forget("sync_updated_since_{$type}");
        Cache::forget("sync_last_sync_{$type}");
    }

    protected static function getSyncType(): string
    {
        return match (static::class) {
            \App\Models\Product::class => 'product',
            \App\Models\Category::class => 'category',
            \App\Models\Carrier::class => 'carrier',
            default => throw new \InvalidArgumentException('Unknown sync model class: ' . static::class),
        };
    }
}
