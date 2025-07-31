<?php

namespace App\Livewire\Catalog\Products;


use App\Models\Marketplace;
use App\Models\Product;
use Livewire\Component;

class Delete extends Component
{


    public function mount($id = null)
    {
        if ($id) {
            $step = request()->query('step'); // type from URL query

            $item = Product::findOrFail($id);
            $item->delete();
            session()->flash('success', __('Successfully deleted.'));
            return redirect()->route('products.index', ['step' => $step]);
        }
    }
}
