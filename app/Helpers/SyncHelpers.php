<?php

use App\Models\SyncBatch;

if (!function_exists('is_sync_running')) {
    function is_sync_running(?string $type = null): bool
    {
        if ($type) {
            $plural = match ($type) {
                'category' => 'categories',
                'product'  => 'products',
                'order'    => 'orders',
                'carrier'  => 'carriers',
                default    => $type . 's',
            };

            return SyncBatch::where('type', $plural)
                ->where('status', 'running')
                ->exists();
        }

        // Αν δεν δοθεί τύπος → έλεγξε όλα
        return SyncBatch::where('status', 'running')->exists();
    }
}
