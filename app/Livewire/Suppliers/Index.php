<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    public $search;
    use WithPagination;
    use WithoutUrlPagination;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $items = Supplier::where(function($query) {
            $query->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('website', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $this->search . '%');
        })->latest()
            ->paginate(2);

        return view('livewire.suppliers.index',[
            'items' => $items,
            'count' => Supplier::all()->count(),
        ]);
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        session()->flash('success',  __('Deleted Successfully'));
        $this->resetPage();

//        return redirect()->route('suppliers.index');
    }
}
