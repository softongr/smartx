<?php

namespace App\Livewire\Marketplaces;

use App\Models\Marketplace;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    public $search;

    use WithPagination;
    use WithoutUrlPagination;
    protected $listeners = ['refreshMarketplaces' => '$refresh'];

    public function render()
    {
        $items = Marketplace::when(trim($this->search),
            function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->latest()->paginate(5);

        $count = Cache::remember('marketplaces_total_count', 3600, function () {
            return Marketplace::count();
        });

        return view('livewire.marketplaces.index', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    public function delete($id)
    {
        $product = Marketplace::findOrFail($id);
        $product->delete();
        Cache::forget('marketplaces_total_count');
        session()->flash('success',  __('Deleted Successfully'));
        return redirect()->route('marketplaces.index');
    }
}
