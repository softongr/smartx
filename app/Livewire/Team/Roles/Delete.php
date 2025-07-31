<?php

namespace App\Livewire\Team\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Delete extends Component
{
    public function mount($role=null)
    {
        if ($role) {
            $item = Role::findOrFail($role);
            $item->delete();
            session()->flash('success',  __('Deleted Successfully'));
            return redirect()->route('roles.index');
        }
    }
}
