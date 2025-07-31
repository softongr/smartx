<?php

namespace App\Livewire\Monitors;

use App\Models\MarketplaceProduct;
use Livewire\Component;

class Index extends Component
{


    public function render()
    {
        $monitors = MarketplaceProduct::with(['product', 'marketplace'])
            ->whereNotNull('external_url')
            ->paginate(20);
        return view('livewire.monitors.index',[
            'items' => $monitors,
        ]);
    }
}
