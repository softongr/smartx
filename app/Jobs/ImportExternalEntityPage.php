<?php

namespace App\Jobs;


use App\Models\SyncChange;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SyncBatch;
use App\Models\Setting;

use App\Services\ShopApiService;
use Illuminate\Support\Facades\Cache;

class ImportExternalEntityPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $tries = 5;
    public string $entityType;
    public int $page;
    public int $syncBatchId;
    public ?string $updatedAfter = null;

    public function __construct(string $entityType, int $page, int $syncBatchId,  $updatedAfter = null)
    {
        $this->entityType   = $entityType;
        $this->page         = $page;
        $this->syncBatchId  = $syncBatchId;
        $this->updatedAfter = $updatedAfter;

    }

    public function handle(): void
    {


        sync_log('info', "Started page", $this->syncBatchId, $this->entityType);
        try {
            $batch = SyncBatch::find($this->syncBatchId);
            if ($batch && !$batch->started_at) {
                $batch->update(['started_at' => now()]);
            }

            $apiResponse = app(ShopApiService::class)->fetch($this->entityType, $this->page, $this->updatedAfter);

            $entities = $apiResponse['data'] ?? [];
            $deleted  = $apiResponse['deleted'] ?? [];
            $model    = $this->resolveModelClass();
            $allData  = [];
            $created  = [];
            $updated  = [];
            $deletedChanges = [];

            sync_log('info', "API returned " . count($entities) . " entities", $this->syncBatchId, $this->entityType);

            foreach ($deleted as $item) {
                if (($item['type'] ?? '') !== $this->entityType || !isset($item['external_id'])) continue;

                if ($model::where('external_id', $item['external_id'])->exists()) {
                    $model::where('external_id', $item['external_id'])->delete();

                    $deletedChanges[] = [
                        'sync_batch_id' => $this->syncBatchId,
                        'entity_type'   => $this->entityType,
                        'external_id'   => $item['external_id'],
                        'action'        => 'deleted',
                        'data'          => json_encode(['deleted_at' => $item['deleted_at'] ?? now()]),
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }
            }

            foreach ($entities as $item) {
                if (!isset($item['external_id'])) {
                    sync_log('warning', "Missing external_id", $this->syncBatchId, $this->entityType);
                    continue;
                }

                $method = 'transform' . ucfirst($this->entityType);
                if (!method_exists($this, $method)) {
                    sync_log('error', "Missing transformer for {$this->entityType}", $this->syncBatchId, $this->entityType);
                    continue;
                }

                $data = $this->{$method}($item);
                $data = array_filter($data, fn($v) => !is_null($v));
                ksort($data);

                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $hash = md5($json);



                $allData[$item['external_id']] = array_merge(
                    ['external_id' => $item['external_id']],
                    $data,
                    ['data_hash' => $hash]
                );
            }

            if (empty($allData) && empty($deletedChanges)) {
                sync_log('info', "No changes detected", $this->syncBatchId, $this->entityType);
                $this->finalizeSync($model, 0);
                return;
            }

            $existing = $model::whereIn('external_id', array_keys($allData))
                ->get(['external_id', 'data_hash'])
                ->keyBy('external_id');

            foreach ($allData as $id => $row) {
                if (!isset($existing[$id])) {
                    $created[] = $this->syncChangeArray($id, 'created', $row);
                } elseif ($existing[$id]->data_hash !== $row['data_hash']) {
                    $updated[] = $this->syncChangeArray($id, 'updated', $row);
                }
            }

            $rawRecords = collect($created)->merge($updated)
                ->pluck('data')
                ->map(fn($json) => json_decode($json, true))
                ->filter(fn($row) => is_array($row) && !empty($row))
                ->values();
            $allKeys = $rawRecords->flatMap(fn($r) => array_keys($r))->unique()->values()->all();
            $toUpsert = $rawRecords
                ->map(fn($row) => $this->normalizeRecordFields($row, $allKeys))
                ->all();

            if (!empty($toUpsert)) {
                $chunkSize = Setting::get('sync_limit', 2500);
                foreach (collect($toUpsert)->chunk($chunkSize) as $chunk) {
                    $records = $chunk->all();

                    if (empty($records)) continue;
                    $first = reset($records);
                    $columns = array_keys($first);
                    foreach ($records as $index => $r) {
                        $actualKeys = array_keys($r);

                        if ($actualKeys !== $columns) {

                            sync_log('error', "Column mismatch at row $index",  $this->syncBatchId, $this->entityType, [
                                    'expected_keys' => $columns,
                                    'actual_keys' => $actualKeys,
                                    'record' => $r,]);
                            continue 2;
                        }
                    }

                    sync_log('info', "Upserting chunk of " . count($records) . " rows", $this->syncBatchId, $this->entityType);
                    $model::upsert($records, ['external_id'], $columns);
                }
            }


            $this->finalizeSync($model, count($created) + count($updated) + count($deletedChanges));
        } catch (\Throwable $e) {
            sync_log('error', "Exception: {$e->getMessage()}", $this->syncBatchId, $this->entityType);
            SyncBatch::find($this->syncBatchId)?->update(['status' => 'failed']);
        }
    }

    private function normalizeRecordFields(array $record, array $allKeys): array
    {
        foreach ($allKeys as $key) {
            if (!array_key_exists($key, $record)) {
                $record[$key] = null;
            }
        }

        ksort($record); // σημαντικό για σταθερότητα
        return $record;
    }

    /********
     * @param string $id
     * @param string $action
     * @param array $data
     * @return array
     */
    private function syncChangeArray(string $id, string $action, array $data): array
    {
        return [
            'sync_batch_id' => $this->syncBatchId,
            'entity_type'   => $this->entityType,
            'external_id'   => $id,
            'action'        => $action,
            'data'          => json_encode($data),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }


    /****
     * @return string
     */
    private function resolveModelClass(): string
    {
        return match ($this->entityType) {
            'category' => \App\Models\Category::class,
            'product'  => \App\Models\Product::class,
            'order'    => \App\Models\Order::class,
           'carrier'   => \App\Models\Carrier::class,
            default    => throw new \InvalidArgumentException("Unknown entity type: {$this->entityType}")
        };
    }

    private function finalizeSync(string $modelClass, $totalItems): void
    {
//        SyncLog::info("Ξεκίνησε finalizeSync", $this->syncBatchId, $this->entityType);
        $batch = SyncBatch::find($this->syncBatchId);
        if (!$batch || $batch->status === 'completed') return;
        $batch->increment('finished_jobs');
        if ($batch->finished_jobs < $batch->total_jobs) return;

        if ($key = $this->notificationSettingKey()) {
            if (Setting::get($key)) {
                event(new \App\Events\SyncBatchCompleted($batch));
            }
        }
        $duration = Carbon::parse($batch->started_at ?? $batch->created_at)->diffInSeconds(now());
        $batch->update([
            'status' => 'completed',
            'duration_seconds' => $duration,
            'total_items' => $totalItems
        ]);

        Cache::forget("sync_stats_{$this->entityType}");
        event(new \App\Events\EntityStatsShouldRecalculate($this->entityType));
//        SyncLog::info("Ολοκληρώθηκε finalize", $this->syncBatchId, $this->entityType, [
//            'duration' => $duration, 'items' => $totalItems
//        ]);
    }


    private function notificationSettingKey(): ?string
    {
        return match ($this->entityType) {
            'category'      => 'notify_on_category_sync',
            'product'       => 'notify_on_product_sync',
            'order'         => 'notify_on_order_sync',
            'carrier'       => 'notify_on_carrier_sync',
            default         => null,
        };
    }

    private function transformCategory(array $item): array
    {
        return [
            'name'              => $item['name'] ?? '',
            'description'       => $item['description'] ?? null,
            'meta_description'  => $item['meta_description'] ?? null,
            'meta_title'        => $item['meta_title'] ?? null,
            'meta_keywords'     => $item['meta_keywords'] ?? null,
            'parent_id'         => $item['id_parent'],
            'link'              => $item['link'] ?? null,
            'active'            => $item['active'] ?? 0,
            'date_add'          => $item['date_add'] ?? null,
            'date_upd'          => $item['date_upd'] ?? null,
        ];
    }


   private function transformProduct(array $item) {
       $pay= [

           'name'                => $item['name'] ?? '',
           'description'         => $item['description'] ?? '',
           'short_description'   => $item['description_short'] ?? '',
           'meta_title'          => $item['meta_title'] ?? '',
           'meta_description'    => $item['meta_description'] ?? '',
           'reference'           => $item['reference'] ?? null,
           'ean'                 => $item['ean13'] ?? null,
           'mpn'                 => $item['mpn'] ?? null,
           'price' => is_numeric($item['price'] ?? null) ? floatval($item['price']) : 0,
           'wholesale_price' => is_numeric($item['wholesale_price'] ?? null) ? floatval($item['wholesale_price']) : 0,
           'source_method'       => 'shop',
           'status'              => 'completed',
           'id_default_category' => $item['id_category_default'] ?? 0,
           'quantity' => isset($item['quantity']) && is_numeric($item['quantity']) ? $item['quantity'] : 0

       ];

//       SyncLog::info(json_encode($pay), $this->syncBatchId, $this->entityType, []);
       return $pay;
   }

   private function transformCarrier(array $item) {
         return [
             'name'     => $item['name'],
             'active'   => $item['active'],
         ];
    }

    /*****
     * @param array $item
     * @return array
     */
   private function transformOrder(array $item): array
   {


        $pay=  [
            'reference'         => $item['reference'] ?? null,
            'state_id'          => $item['state_id'] ?? null,
            'state_name'        => $item['state_name'] ?? null,
            'carrier_id'        => $item['carrier_id'] ?? null,
            'carrier_name'      => $item['carrier_name'] ?? null,
            'payment_id'        => $item['payment_id'] ?? null,
            'payment_name'      => $item['payment_name'] ?? null,
            'notes'             => $item['notes'] ?? null,
            'order_total'       => $item['order_total'] ?? 0,
            'order_discount'    => $item['order_discount'] ?? 0,
            'currency'          => $item['currency'] ?? 'EUR',
            'weight'            => $item['weight'] ?? 0,
            'shipping_charge'   => $item['shipping_charge'] ?? 0,
            'customer_id'       => $item['customer_id'],
            'customer_email'    => $item['customer_email'] ?? null,
            'order_created_at'  =>  $this->normalizeDatetime($item['created_at'] ?? null),
            'order_updated_at'  => $this->normalizeDatetime($item['updated_at'] ?? null),
            'items'             => json_encode($item['items'] ?? []),
            'shipping_address'  => json_encode($item['shipping_address'] ?? []),
            'billing_address'   => json_encode($item['billing_address'] ?? []),
        ];

        return  $pay;
    }

    private function normalizeDatetime(?string $input): ?string
    {
        if (empty($input)) return null;

        try {
            return \Carbon\Carbon::parse($input)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null; // ή log αν θες
        }
    }
}
