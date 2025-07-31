<?php

namespace App\Livewire\Synchronization;

use App\Jobs\ImportPrestashopProductPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Product extends Component
{
    public $search;
    public $message=null;
    use WithPagination;
    use WithoutUrlPagination;


    public function getListeners()
    {
        return [
            'refreshComponent' => '$refresh',
        ];
    }

    public function render()
    {
        $this->checkSyncStatus();

        $query = \App\Models\Product::select('id', 'name', 'price', 'ean', 'mpn', 'prestashop_id', 'link')
            ->where('prestashop_id', '!=', 0);


        $query->where(function ($q) {
            $q->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('mpn', 'LIKE', '%' . $this->search . '%')
                ->orWhere('ean', 'LIKE', '%' . $this->search . '%')
                ->orWhere('prestashop_id', $this->search);
        });


        $items = $query->latest()->paginate(10);

        $count = Cache::remember('products_count', now()->addMinutes(5), function () {
            return \App\Models\Product::where('prestashop_id', '!=', 0)->count();
        });


        return view('livewire.synchronization.product',
            [
                'items' => $items,
                'count' => $count,
            ]);

    }


    public function checkSyncStatus()
    {
        if (Cache::has('products_sync_finished')) {
            session()->flash('success', 'Ο συγχρονισμός των προϊόντων ολοκληρώθηκε!');
            Cache::forget('products_sync_finished');
        }
    }

    public function sync()
    {


        try {

            $response = Http::timeout(10)->withOptions(['verify' => false])->get("https://housephone.gr/each-product", [
                'page' => 1,
                'limit' => 500
            ])->throw(); // ← Θα σκάσει αν έχει σφάλμα HTTP




            $total = $response->json('total') ?? 0;

            $limit = 500;
            $totalPages = (int) ceil($total / $limit);

            if ($totalPages === 0) {

                session()->flash('error',  __('No products found to sync.'));
                return;
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                ImportPrestashopProductPage::dispatch($i, $totalPages)->delay(now()->addSeconds($i));
            }


            session()->flash('success',  __('Synced started successfully'));

        } catch (\Exception $e) {
            $this->message = "Σφάλμα κατά το συγχρονισμό: " . $e->getMessage();
        }
    }

}
