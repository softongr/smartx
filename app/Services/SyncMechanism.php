<?php

namespace App\Services;

use App\Jobs\ImportExternalEntityPage;
use App\Models\Setting;
use App\Models\SyncBatch;
use Illuminate\Support\Facades\DB;

class SyncMechanism
{
    /**
     * Starts synchronization for a given entity type.
     *
     * @param string $type     Entity type: product, shop, category, etc.
     * @param string|null $updatedAfter  Optional: fetch only updated records
     * @return SyncBatch|null
     */
    public function run(string $type, ?string $updatedAfter = null, string $triggeredBy = 'manual'): ?SyncBatch
    {
        $mapping = [
            'product'  => 'products',
            'shop'     => 'shops',
            'category' => 'categories',
            'order'    => 'orders',
            'carrier'  => 'carriers',
        ];

        if (!array_key_exists($type, $mapping)) {
            throw new \InvalidArgumentException("Invalid sync type: {$type}");
        }

        if (is_sync_running($type)) {
            return null;
        }

        $pluralType = $mapping[$type];
        $updatedAfter = $updatedAfter ?? $this->getLastCompletedSyncTime($pluralType);
        $perPage = Setting::get('sync_per_page', 50);

        $shopApi = app(\App\Services\ShopApiService::class);
        $total = $shopApi->count($type, $updatedAfter);
        $totalPages = (int) ceil($total / $perPage);



        DB::beginTransaction();

        $batch = SyncBatch::create([
            'type'          => $pluralType,
            'status'        => ($totalPages) ? 'running' : 'completed',
            'total_jobs'    => $totalPages,
            'finished_jobs' => 0,
            'triggered_by'  => $triggeredBy,
        ]);

        for ($page = 1; $page <= $totalPages; $page++) {
            ImportExternalEntityPage::dispatch($type, $page, $batch->id, $updatedAfter);
        }

        DB::commit();

        return $batch;
    }

    /**
     * Returns last completed sync timestamp for a type.
     */
    private function getLastCompletedSyncTime(string $type): ?string
    {
        return SyncBatch::where('type', $type)
            ->where('status', 'completed')
            ->latest('updated_at')
            ->value('updated_at');
    }
}
