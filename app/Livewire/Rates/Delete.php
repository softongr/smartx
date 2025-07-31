<?php

namespace App\Livewire\Rates;

use App\Models\RateVat;
use Livewire\Component;

class Delete extends Component
{

    public function mount($rate=null)
    {

        if ($rate) {
            try {
                $item = RateVat::findOrFail($rate);
                if (!$item->seed) {
                    $item->delete();
                    session()->flash('success', __('Διαγράφηκε με επιτυχία.'));
                }
                session()->flash('error', 'Δεν μπορείτε να το διαγράψετε....');

            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
            }

            return redirect()->route('rates.index');
        }
    }
}
