<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class ShopApiService
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
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
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

    public function send($payload)
    {
        return $this->post($this->resolveEndpoint('receiver'), $payload);

    }

    /**
     * Check αν το API είναι διαθέσιμο και authenticated
     */
    public function isAuthenticated(): bool
    {
        try {
            $response = Http::withHeaders([
                'soft19-x-api' => $this->apiKey,
            ])->post("{$this->baseUrl}{$this->resolveEndpoint('check')}");

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
    public function count(string $table, $updatedAfter=null): int
    {
        $result = $this->post($this->resolveEndpoint('count'), [
            'table' => $table,
            'updatedAfter' => $updatedAfter
        ]);

        return $result['count'] ?? 0;
    }




    public function fetch(string $table, int $page = 1, ?string $updatedAfter = null): array
    {
        $payload = [
            'table' => $table,
            'page' => $page,
            'limit' => $this->limit,
        ];

        if ($updatedAfter) {
            $payload['updatedAfter'] = $updatedAfter;
        }
        $endpoint = $this->resolveEndpoint('api');

        return $this->post($endpoint, $payload);


    }

    /**
     * Επιστροφή μιας εγγραφής με βάση το ID
     */
    public function entry(string $table, int $id): ?array
    {
        $result = $this->post($this->resolveEndpoint('entry'), [
            'table' => $table,
            'id' => $id,
        ]);

        return $result['data'] ?? null;
    }


    protected function resolveEndpoint(string $type): string
    {
        $platform = Setting::get('shop_platform', 'prestashop');

        return match ($type) {
            'api' => match ($platform) {
                'prestashop'   => '/module/soft19/api',
                'woocommerce'  => '/wp-json/soft19/v1/api',
                'opencart'       => '/api/data',
                'magento'       => '/api/data',
                'cscart'       => '/api/check',
                default        => throw new \Exception("Unsupported platform: $platform"),
            },
            'count' => match ($platform) {
                'prestashop'   => '/module/soft19/count',
                'woocommerce'  => '/wp-json/soft19/v1/count',
                'opencart'       => '/api/count',
                'cscart'       => '/api/check',
                default        => throw new \Exception("Unsupported platform: $platform"),
            },
            'entry' => match ($platform) {
                'prestashop'   => '/module/soft19/entry',
                'woocommerce'  => '/wp-json/soft19/v1/entry',
                'opencart'       => '/api/entry',
                'magento'       => '/api/entry',
                'cscart'       => '/api/check',
                default        => throw new \Exception("Unsupported platform: $platform"),
            },
            'receiver' => match ($platform) {
                'prestashop'   => '/module/soft19/receiver',
                'woocommerce'  => '/wp-json/soft19/v1/receiver',
                'opencart'       => '/api/receiver',
                'magento'       => '/api/receiver',
                'cscart'       => '/api/check',
                default        => throw new \Exception("Unsupported platform: $platform"),
            },
            'check' => match ($platform) {
                'prestashop'   => '/module/soft19/check',
                'woocommerce'  => '/wp-json/soft19/v1/check',
                'opencart'       => '/api/check',
                'magento'       => '/api/check',
                'cscart'       => '/api/check',
                default        => throw new \Exception("Unsupported platform: $platform"),
            },
            default => throw new \Exception("Unknown endpoint type: $type"),
        };
    }
}
