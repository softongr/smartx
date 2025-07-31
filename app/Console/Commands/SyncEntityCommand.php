<?php

namespace App\Console\Commands;

use App\Jobs\ImportExternalEntityPage;
use App\Models\Setting;
use App\Models\SyncBatch;
use App\Services\ShopApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:entity {type : The type of entity to sync (e.g. product, shop)}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync any entity type from external API';


    /**
     * Execute the console command.
     */
    public function handle(ShopApiService $shopApi)
    {
        $inputType = $this->argument('type');

        $validTypes = ['product', 'shop', 'category', 'order', 'carrier'];

        $typeMap = [
            'product' => 'products',
            'shop' => 'shops',
            'category' => 'categories',
            'order' => 'orders',
            'carrier' => 'carriers',
        ];

        if (!in_array($inputType, $validTypes)) {
            $this->error("Invalid type '{$inputType}'. Allowed types: " . implode(', ', $validTypes));
            return 1;
        }

        if (is_sync_running($inputType)) {
            $this->warn("A sync process for '{$inputType}' is already running. Aborting.");
            return 1;
        }

        $updatedAfter = last_completed_sync_time($typeMap[$inputType]);
        $mechanism = app(\App\Services\SyncMechanism::class);
        $batch = $mechanism->run($inputType, $updatedAfter, 'cron');

        if (!$batch) {
            $this->warn("Sync for '{$inputType}' did not start.");
            return 1;
        }

        $this->info("Dispatched {$batch->total_jobs} {$inputType} import jobs.");
        return 0;
    }


}
