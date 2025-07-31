<?php

namespace App\Services;

use App\Models\DebugLog;
use App\Models\Product;
use App\Models\ScrapingLog;
use App\ProductStep;
use App\Services\RemoteHtmlClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProductHtmlDownloader
{
    public function __construct(
        protected RemoteHtmlClient $htmlClient
    ) {}

    public function handle(int $productId, string $provider = 'oxylabs'): bool
    {
        $product = Product::find($productId);

        if (!$product || !$product->scrape_link) {
            DebugLog::warning('ProductHtmlDownloader', 'handle', 'Missing product or scrape_link', [], $productId);

            return false;
        }

        DebugLog::info('ProductHtmlDownloader', 'handle', 'Starting HTML download process', [
            'url' => $product->scrape_link
        ], $productId);


        $startedAt = now();

        try {
            $html = $this->htmlClient->fetch($product->scrape_link, $provider,$productId);

        } catch (\Throwable $e) {
            DebugLog::error('ProductHtmlDownloader', 'handle', 'Exception during fetch', [
                'error' => $e->getMessage(),
            ], $productId);
            return false;
        }

        $finishedAt = now();
        $duration = $startedAt->diffInSeconds($finishedAt);

        if (!$html) {
            DebugLog::warning('ProductHtmlDownloader', 'handle', 'HTML fetch returned empty or failed.', [
                'duration' => $duration,
            ], $productId);
            return false;
        }

        $product->update(['html' => $html]);

        if ($product->step === ProductStep::Scrape) {
            $product->update(['step' => ProductStep::Parse]);
            DebugLog::info('ProductHtmlDownloader', 'handle', 'Step updated to Parse', [], $productId);


        }

        DebugLog::info('ProductHtmlDownloader', 'handle', 'HTML successfully saved', [
            'duration' => $duration,
        ], $productId);

        return true;
    }


}
