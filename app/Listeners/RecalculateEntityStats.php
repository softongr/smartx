<?php

namespace App\Listeners;

use App\Events\EntityStatsShouldRecalculate;
use App\Models\SyncBatch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;


class RecalculateEntityStats
{
    /**
     * Create the event listener.
     */
    public function handle(EntityStatsShouldRecalculate $event): void
    {
        $type = $event->type;

        $modelClass = match ($type) {
            'category' => \App\Models\Category::class,
            'product' => \App\Models\Product::class,
            'carrier' => \App\Models\Carrier::class,
            'order' => \App\Models\Order::class,
            default => null,
        };

        if (!$modelClass) {
            return;
        }

        $pluralType = match ($type) {
            'category' => 'categories',
            'product' => 'products',
            'carrier' => 'carriers',
            'order' => 'orders',
            default => $type . 's',
        };

        $lastSync = SyncBatch::where('type', $pluralType)
            ->where('status', 'completed')
            ->latest('updated_at')
            ->first();

        $latestSyncAt = $lastSync?->updated_at;

        $stats = [
            'count' => $modelClass::count(),
            'new_today' => $modelClass::whereDate('created_at', today())->count(),
            'new_since_last' => $latestSyncAt
                ? $modelClass::where('created_at', '>=', $latestSyncAt)->count()
                : 0,
            'updated_since_last' => $latestSyncAt
                ? $modelClass::where('updated_at', '>=', $latestSyncAt)
                    ->whereColumn('created_at', '<', 'updated_at')
                    ->count()
                : 0,
            'latest_sync' => $latestSyncAt,
        ];

        Cache::put("sync_stats_{$type}", $stats);

        logger("✅ Cache ανανεώθηκε για: {$type}");
    }
}
