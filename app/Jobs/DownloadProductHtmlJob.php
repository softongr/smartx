<?php

namespace App\Jobs;

use App\Events\JobCompleted;
use App\Models\DebugLog;
use App\Services\ProductHtmlDownloader;
use App\Services\ScrapingLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\RateLimiter;
class DownloadProductHtmlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public int $tries = 3;
    public int $timeout = 120;
    /**
     * Create a new job instance.
     */
    public function __construct(public int $productId) {}


    /**
     * Execute the job.
     */
    public function handle(ProductHtmlDownloader $downloader): void
    {
        $key = "scraping:running:product:{$this->productId}";
        Cache::put($key, true, 180);
        $startedAt = now();

        try {
            sleep(rand(1, 3));
            DebugLog::info('DownloadProductHtmlJob', 'handle', 'Job started', [], $this->productId);


            $rateKey = 'scraping:oxylabs:global';
            if (RateLimiter::tooManyAttempts($rateKey, 10)) {
                $wait = RateLimiter::availableIn($rateKey);
                DebugLog::warning('DownloadProductHtmlJob', 'handle', "Rate limiter active, sleeping {$wait}s", [], $this->productId);

                sleep(RateLimiter::availableIn($rateKey));
            }
            RateLimiter::hit($rateKey, 10);

            $lockKey = "scrape:product:{$this->productId}";
            Cache::lock($lockKey, 120)->block(5, function () use ($downloader) {
                DebugLog::info('DownloadProductHtmlJob', 'handle', 'Lock acquired', [], $this->productId);
                $downloader->handle($this->productId, 'oxylabs');
            });

        }catch (\Throwable $e) {
            DebugLog::error('DownloadProductHtmlJob', 'handle', 'Unhandled exception', [
                'error' => $e->getMessage(),
            ], $this->productId);

        }finally {
            $finishedAt = now();
            $duration = $startedAt->diffInSeconds($finishedAt);

            DebugLog::info('DownloadProductHtmlJob', 'handle', 'Job finished', [
                'duration' => $duration,
            ], $this->productId);

            Cache::forget($key);
        }
    }
}
