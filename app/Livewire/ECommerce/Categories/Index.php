<?php

namespace App\Livewire\ECommerce\Categories;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $search;


    public function render()
    {

        $query = \App\Models\Category::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('external_id', 'LIKE', '%' . $this->search . '%');
            });
        }
        $items = $query->latest()->paginate(20);

        return view('livewire.e-commerce.categories.index',[
            'items' => $items,
            'count' => \App\Models\Category::all()->count(),
        ]);
    }
}
