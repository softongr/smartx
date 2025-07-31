<?php

use App\Services\ShopApiService;
use Illuminate\Support\Facades\Cache;

if (!function_exists('is_api_authenticated')) {
    function is_api_authenticated(): bool
    {
        return Cache::rememberForever('shop_api_authenticated', function () {
            try {
                $api = app(ShopApiService::class);
                return $api->isAuthenticated();
            } catch (\Throwable $e) {
                \Log::error('Global API auth helper failed', ['error' => $e->getMessage()]);
                return false;
            }
        });
    }
}
