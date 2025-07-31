<?php

namespace App\Livewire\Synchronization;

use App\Jobs\ImportPrestashopCategoryPage;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Category extends Component
{

    use WithPagination;
    use withoutUrlPagination;
    public $search;
    public $message =null;

    public function render()
    {

        $query = \App\Models\Category::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('prestashop_id', 'LIKE', '%' . $this->search . '%');
            });
        }
        $items = $query->latest()->paginate(10);

        return view('livewire.synchronization.category',[
            'items' => $items,
            'count' => \App\Models\Category::all()->count(),
        ]);
    }


    public function sync()
    {


        try {

            $response = Http::timeout(10)->withOptions(['verify' => false])->get("https://smartx.gr/each-category", [
                'page' => 1,
                'limit' => 50
            ])->throw(); // ← Θα σκάσει αν έχει σφάλμα HTTP

            $total = $response->json('total') ?? 0;
            $limit = 50;
            $totalPages = (int) ceil($total / $limit);

            if ($totalPages === 0) {

                session()->flash('error',  __('No categories found to sync.'));
                return;
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                ImportPrestashopCategoryPage::dispatch($i)->delay(now()->addSeconds($i));
            }


            session()->flash('success',  __('Synced started successfully'));

        } catch (\Exception $e) {
            $this->message = "Σφάλμα κατά το συγχρονισμό: " . $e->getMessage();
        }
    }
}
