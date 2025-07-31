<?php
use App\Models\Setting;
use App\Models\SyncLog;


if (!function_exists('user_ip')) {
    function user_ip(): string
    {
        return request()->ip();
    }
}


if (!function_exists('default_rate')) {
    function default_rate(): ?\App\Models\RateVat
    {
        return \App\Models\RateVat::where('default', true)->first(); // Επιστρέφει την πρώτη εγγραφή
    }
}

if (!function_exists('last_completed_sync_time')) {
    function last_completed_sync_time(string $type): ?string {
        return \App\Models\SyncBatch::where('type', $type)
            ->where('status', 'completed')
            ->latest('updated_at')
            ->value('updated_at');
    }
}


if (!function_exists('sync_log')) {
    function sync_log(string $level, string $message, int $batchId, string $type, array $context = []): void
    {
        if (!Setting::get('sync_log_enabled', true)) {
            return;
        }
        match ($level) {
            'info'    => SyncLog::info($message, $batchId, $type, $context),
            'error'   => SyncLog::error($message, $batchId, $type, $context),
            'warning' => SyncLog::warning($message, $batchId, $type, $context),
            default   => null
        };
    }
}



if (!function_exists('isEnableLogSync')) {
    function isEnableLogSync(): bool
    {
        return (bool) Setting::get('sync_log_enabled', true);
    }
}
if (!function_exists('isScrapeLogEnabled')) {
    function isScrapeLogEnabled(): bool
    {
        return \App\Models\Setting::get('sync_log_enabled', true);
    }
}

if (!function_exists('scraping_log')) {
    function scraping_log(
        int     $productId,
        string  $status,
        string  $message,
        string  $provider = 'oxylabs',
        ?\Carbon\Carbon $startedAt = null,
        ?\Carbon\Carbon $finishedAt = null,
        ?float  $duration = null,
    ): void {
        \App\Models\ScrapingLog::create([
            'product_id'  => $productId,
            'provider'    => $provider,
            'status'      => $status,
            'message'     => $message,
            'started_at'  => $startedAt,
            'finished_at' => $finishedAt,
            'duration'    => $duration,
        ]);
    }
}


if (! function_exists('get_running_products_scraping')) {
    function get_running_products_scraping(){
        $products = \App\Models\Product::whereNull('external_id')->pluck('id');
        $running = [];
        foreach ($products as $id) {
            if (\Illuminate\Support\Facades\Cache::has("scraping:running:product:$id")) {
                $running[] = $id;
            }
        }
        return $running;
    }
}

if (! function_exists('check_product_status')) {
    function check_product_status($productId){
        $runningProducts = get_running_products_scraping(); // Καλούμε την ήδη υπάρχουσα συνάρτηση
        return in_array($productId, $runningProducts) ? true : false;
    }
}
