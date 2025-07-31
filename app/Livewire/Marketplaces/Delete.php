<?php

namespace App\Livewire\Marketplaces;

use App\Models\Marketplace;
use Livewire\Component;

class Delete extends Component
{
    public function mount($marketplace=null)
    {
        if ($marketplace)
        {
            $item = Marketplace::findOrFail($marketplace);
            $item->delete();
            session()->flash('success', __('Successfully deleted.'));
            return redirect()->route('marketplaces.index');
        }
    }
}
