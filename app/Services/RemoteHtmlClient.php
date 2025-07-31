<?php


namespace App\Services;
use App\Models\DebugLog;
use Illuminate\Support\Facades\Log;

use App\Models\ScrapingLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class RemoteHtmlClient
{
    public function fetch(string $url, string $provider = 'oxylabs', ?int $productId = null): ?string
    {
        return match ($provider) {
            'oxylabs' => $this->fromOxylabs($url, $productId),

            'scraperapi' => $this->fromScraperAPI($url),
            'custom' => $this->fromCustomProxy($url),
            default => null,
        };
    }

    protected function fromOxylabs(string $url, ?int $productId = null): ?string
    {

        $username = 'mytesti_8JQ36';
        $password = 'n_n8g+FJ4sL4cd=';
        try {
            $params = [
                'source' => 'universal',
                'url'    => $url,
            ];

            DebugLog::debug('RemoteHtmlClient', 'fromOxylabs', 'Sending request to Oxylabs', [
                'url' => $url,
            ], $productId);

            $response = Http::timeout(60)
                ->withOptions([
                    'connect_timeout' => 5,
                ])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'User-Agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                ])
                ->withBasicAuth($username, $password)
                ->post('https://realtime.oxylabs.io/v1/queries', $params);

            DebugLog::info('RemoteHtmlClient', 'fromOxylabs', 'Response received', [
                'status' => $response->status(),
                'body_snippet' => substr($response->body(), 0, 300),
            ], $productId);


            if (!$response->ok()) {
                DebugLog::warning('RemoteHtmlClient', 'fromOxylabs', 'Non-OK response', [
                    'status' => $response->status(),
                ],$productId);
                return null;
            }

            $json = $response->json();
            $html = $json['results'][0]['content'] ?? null;


            if (!$html) {

                DebugLog::warning('RemoteHtmlClient', 'fromOxylabs', 'Empty content received from Oxylabs', [], $productId);

                return null;
            }

            DebugLog::info('RemoteHtmlClient', 'fromOxylabs', 'HTML content fetched successfully', [], $productId);


            return $html;

        } catch (\Throwable $e) {
            DebugLog::error('RemoteHtmlClient', 'fromOxylabs', 'Exception during fetch', [
                'error' => $e->getMessage(),
            ],$productId);
            return null;
        }
    }


    protected function fromScraperAPI(string $url): ?string
    {
        $apiKey = config('services.scraperapi.key');
        $response = Http::get("http://api.scraperapi.com", [
            'api_key' => $apiKey,
            'url' => $url,
        ]);
        return $response->ok() ? $response->body() : null;
    }

    protected function fromCustomProxy(string $url): ?string
    {
        $response = Http::get('https://your-custom-proxy.com/fetch', [
            'url' => $url,
        ]);

        return $response->ok() ? $response->body() : null;
    }


}
