<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class ShopApiService1
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $limit;

    public function __construct()
    {
        $this->baseUrl = rtrim(Setting::get('shop_link', ''), '/');
        $this->apiKey = Setting::get('shop_api_key', '');
        $this->limit = Setting::get('sync_per_page', 50);
    }

    /**
     * Γενικό POST request με headers και error handling
     */
    protected function post(string $endpoint, array $payload = []): ?array
    {
        try {
            $response = Http::withHeaders([
                'soft19-x-api' => $this->apiKey,
            ])->post("{$this->baseUrl}{$endpoint}", $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Shop API error at {$endpoint}", [
                'payload' => $payload,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error("Shop API exception at {$endpoint}", [
                'payload' => $payload,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * Check αν το API είναι διαθέσιμο και authenticated
     */
    public function isAuthenticated(): bool
    {
        try {
            $response = Http::withHeaders([
                'soft19-x-api' => $this->apiKey,
            ])->post("{$this->baseUrl}/module/soft19/check");

            $json = $response->json();

            return $response->ok() && ($json['authenticated'] ?? false) === true;
        } catch (\Throwable $e) {
            Log::error("Shop API connection check failed", [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Επιστροφή πλήθους εγγραφών για πίνακα (π.χ. orders, categories)
     */
    public function count(string $table): int
    {
        $result = $this->post('/module/soft19/count', [
            'table' => $table,
        ]);

        return $result['count'] ?? 0;
    }


    public function fetch(string $table, int $page = 1, int $limit = 50): array
    {
        $result = $this->post('/module/soft19/api', [
            'table' => $table,
            'page' => $page,
            'limit' => $this->limit,
        ]);

        return $result['data'] ?? [];
    }

    /**
     * Επιστροφή μιας εγγραφής με βάση το ID
     */
    public function entry(string $table, int $id): ?array
    {
        $result = $this->post('/module/soft19/entry', [
            'table' => $table,
            'id' => $id,
        ]);

        return $result['data'] ?? null;
    }
}
