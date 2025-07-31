<?php

namespace App\Console\Commands;

use App\Jobs\DownloadProductHtmlJob;
use App\Livewire\OpenAi\Mapper\Product;
use App\Models\ScrapingLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class DownloadProductHtmlBatchCommand extends Command
{

    protected $signature = 'products:download-html {--limit=20 : Number of products to process}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $description = 'Dispatch a batch of DownloadProductHtmlJob for products with non-null scrape_link';



    /**
     * Execute the console command.
     */
    public function handle()
    {

        $limit = (int) $this->option('limit');
        $products = \App\Models\Product::where('step', 1)
            ->where('source_method', 'scrape')
            ->orderByDesc('id')
            ->take($limit)
            ->get();



        if ($products->isEmpty()) {
            $this->warn('No products found to process.');
            return;
        }

        $this->info("Dispatching download jobs for {$products->count()} products...");

        try {
            $batch = Bus::batch(
                $products->map(fn($product) => new DownloadProductHtmlJob($product->id))
            )->name('Download HTML Batch')
                ->onQueue('scraping')
                ->then(function () {
                })
                ->catch(function (\Throwable $e) {
                    Log::error('Download HTML batch failed', [
                        'error' => $e->getMessage(),
                    ]);
                })
                ->dispatch();
            $this->info("Batch #{$batch->id} dispatched successfully.");

        } catch (\Throwable $e) {
            Log::error('Failed to dispatch download HTML batch', [
                'error' => $e->getMessage(),
            ]);

            $this->error('Error dispatching download batch. Check logs.');
        }
    }
}
