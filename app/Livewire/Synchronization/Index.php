<?php

namespace App\Livewire\Synchronization;

use App\Jobs\ImportExternalEntityPage;
use App\Models\Carrier;
use App\Models\Setting;
use App\Models\SyncBatch;
use App\Services\ShopApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;


class Index extends Component
{
    public array $entityTypes = ['category', 'product','carrier','order'];

    public array $batches = [];

    public function mount(): void
    {
        $this->refreshBatches();

    }

    public function render()
    {
        $this->refreshBatches();

        $counts = [];
        $newToday = [];
        $newSinceLast = [];
        $updatedSinceLast = [];
        $latestSyncs = [];

        foreach ($this->entityTypes as $type) {
            $batch = $this->batches[$type] ?? null;
            $stats = Cache::get("sync_stats_{$type}");

            if (!$stats) {
                $this->recalculateStatsFor($type);
                $stats = Cache::get("sync_stats_{$type}");
            }


            $modelClass = $this->resolveModelClass($type);
            if ($batch && $batch->status === 'running') {
                $stats['count'] = $modelClass::count();
                $stats['new_today'] = $modelClass::whereDate('created_at', today())->count();
            }

            $counts[$type] = $stats['count'] ?? 0;
            $newToday[$type] = $stats['new_today'] ?? 0;
            $newSinceLast[$type] = $stats['new_since_last'] ?? 0;
            $updatedSinceLast[$type] = $stats['updated_since_last'] ?? 0;
            $latestSyncs[$type] = $stats['latest_sync'] ?? null;
        }


        return view('livewire.synchronization.index', [
            'entityTypes' => $this->entityTypes,
            'counts' => $counts,
            'newToday' => $newToday,
            'newSinceLast' => $newSinceLast,
            'updatedSinceLast' => $updatedSinceLast,
            'latestSyncs' => $latestSyncs,
        ]);
    }

    public function startSync(string $type, ShopApiService $shopApi): void
    {
        try {
            if (!is_api_authenticated()) {
                session()->flash('error', __('API Key Not Authorized'));
                return;
            }
            $updatedAfter = $this->getLastCompletedSyncTime($type);

            Cache::forget("sync_stats_{$type}");
            $perPage = Setting::get('sync_per_page', 50);
            $m  = ($type === 'order') ? 'order' : $type;


            $total = $shopApi->count($m, $updatedAfter);








            if ($total) {
                $totalPages = (int) ceil($total / $perPage);
                DB::beginTransaction();
                $batch = SyncBatch::create([
                    'type' => $this->pluralizeType($type),
                    'status' => 'running',
                    'total_jobs' => $totalPages,
                    'finished_jobs' => 0,
                ]);

                for ($page = 1; $page <= $totalPages; $page++) {
                    ImportExternalEntityPage::dispatch($type, $page, $batch->id,$updatedAfter);
                }

                DB::commit();

                $this->batches[$type] = $batch;
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __(':type Synchronization Error', ['type' => ucfirst($type)])
            ]);
        }
    }

    public function getProgressFor(string $type): int
    {
        return $this->calculateProgress($this->batches[$type] ?? null);
    }

    private function refreshBatches(): void
    {
        foreach ($this->entityTypes as $type) {
            $this->batches[$type] = SyncBatch::latest()
                ->where('type', $this->pluralizeType($type))
                ->first();
        }
    }

    private function calculateProgress(?SyncBatch $batch): int
    {
        if (!$batch || $batch->total_jobs === 0) {
            return 0;
        }

        return (int) round(($batch->finished_jobs / $batch->total_jobs) * 100);
    }

    private function pluralizeType(string $type): string
    {
        return match ($type) {
            'category' => 'categories',
            'product' => 'products',
            'order' => 'orders',
            'carrier' => 'carriers',
            default => $type . 's',
        };
    }

    private function resolveModelClass(string $type): string
    {
        return match ($type) {
            'category' => \App\Models\Category::class,
            'product' => \App\Models\Product::class,
            'carrier' => Carrier::class,
            'order' => \App\Models\Order::class,
            default => throw new \InvalidArgumentException("Unknown type: {$type}")
        };
    }


    private function recalculateStatsFor(string $type): void
    {
        $modelClass = $this->resolveModelClass($type);
        $pluralType = $this->pluralizeType($type);

        $lastSync = SyncBatch::where('type', $pluralType)
            ->where('status', 'completed')
            ->latest('updated_at')
            ->first();

        $latestSyncAt = $lastSync?->updated_at;

        $stats = [
            // ✅ μόνο όσα έχουν external_id ≠ 0
            'count' => $modelClass::where('external_id', '!=', null)->count(),

            'new_today' => $modelClass::where('external_id', '!=', null)
                ->whereDate('created_at', today())
                ->count(),

            'new_since_last' => $latestSyncAt
                ? $modelClass::where('external_id', '!=', null)
                    ->where('created_at', '>=', $latestSyncAt)
                    ->count()
                : 0,

            'updated_since_last' => $latestSyncAt
                ? $modelClass::where('external_id', '!=', null)
                    ->where('updated_at', '>=', $latestSyncAt)
                    ->whereColumn('created_at', '<', 'updated_at')
                    ->count()
                : 0,

            'latest_sync' => $latestSyncAt,
        ];

        Cache::put("sync_stats_{$type}", $stats);
    }


    public function startFullSync(ShopApiService $shopApi): void
    {
        foreach ($this->entityTypes as $type) {
            $this->startSync($type, $shopApi);
            usleep(300000); // 0.3 δευτερόλεπτα delay (προαιρετικό)
        }
    }

    public function isAnySyncRunning(): bool
    {
        foreach ($this->batches as $batch) {
            if ($batch && $batch->status === 'running') {
                return true;
            }
        }
        return false;
    }

    private function getLastCompletedSyncTime(string $type): ?string
    {
        $pluralType = $this->pluralizeType($type);

        $batch = SyncBatch::where('type', $pluralType)
            ->where('status', 'completed')
            ->latest('updated_at')
            ->first();

        return $batch?->updated_at;

    }
}
