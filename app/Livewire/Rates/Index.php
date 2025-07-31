<?php

namespace App\Livewire\Rates;

use App\Models\Marketplace;
use App\Models\RateVat;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{

    public $search;

    use WithPagination;
    use WithoutUrlPagination;


    public function render()
    {

        $items = RateVat::when(trim($this->search), function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
            ->latest()
            ->paginate(5);



        return view('livewire.rates.index', [
            'items' => $items,
            'count' => RateVat::count(),
        ]);
    }

    public function setAsDefault($id)
    {

        RateVat::where('default', true)->update(['default' => false]);

        // Κάνει default την επιλεγμένη
        $item = \App\Models\RateVat::findOrFail($id);
        $item->default = true;
        $item->save();

        session()->flash('success', 'Ορίστηκε ως προεπιλεγμένο');
        return redirect()->route('rates.index');
    }
}
