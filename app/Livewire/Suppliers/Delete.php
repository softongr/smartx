<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Delete extends Component
{

    public function mount($supplier=null)
    {
        if ($supplier) {
            $item = Supplier::findOrFail($supplier);
            $item->delete();
            session()->flash('success',  __('Deleted Successfully'));
            return redirect()->route('suppliers.index');
        }
    }
}
