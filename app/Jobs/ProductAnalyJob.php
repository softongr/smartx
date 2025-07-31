<?php

namespace App\Jobs;

use App\Models\DebugLog;
use App\Services\ProductAnaly;
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
class ProductAnalyJob implements ShouldQueue
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
    public function handle(ProductAnaly $analy): void
    {
        $key = "analytics:running:product:{$this->productId}";
        Cache::put($key, true, 180);
        $startedAt = now();

        try {
            sleep(rand(1, 2));
            DebugLog::info('ProductAnalyJob', 'handle', 'Job started', [], $this->productId);

            $rateKey = 'analytics:global';
            if (RateLimiter::tooManyAttempts($rateKey, 10)) {
                $wait = RateLimiter::availableIn($rateKey);
                DebugLog::warning('ProductAnalyJob', 'handle', "RateLimiter active. Sleeping for {$wait}s", [], $this->productId);

                sleep(RateLimiter::availableIn($rateKey));
            }
            RateLimiter::hit($rateKey, 5);

            $lockKey = "analytics:product:{$this->productId}";
            Cache::lock($lockKey, 120)->block(5, function () use ($analy) {
                DebugLog::info('ProductAnalyJob', 'handle', 'Lock acquired. Starting analysis.', [], $this->productId);

                $analy->handle($this->productId);
            });

        }catch (\Throwable $e) {
            DebugLog::error('ProductAnalyJob', 'handle', 'Unhandled exception', [
                'error' => $e->getMessage(),
            ], $this->productId);


        }finally {
            $finishedAt = now();
            $duration = $startedAt->diffInSeconds($finishedAt);

            DebugLog::info('ProductAnalyJob', 'handle', 'Job finished', [
                'duration' => $duration,
            ], $this->productId);


            Cache::forget($key);
        }
    }
}
