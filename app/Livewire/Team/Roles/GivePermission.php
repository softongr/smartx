<?php

namespace App\Livewire\Team\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GivePermission extends Component
{
    public $roleId;
    public $role;
    public $permissions = [];
    public $selectAll;
    public $selectedPermissions = [];


    public function mount($role)
    {
        $this->roleId              = $role;
        $this->role                = Role::findOrFail($role);
        $this->permissions         = Permission::all();
        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function save()
    {
        $this->role->syncPermissions($this->selectedPermissions);
        session()->flash('success', __('Permissions updated successfully'));
        return redirect()->route('role.permissions', ['role' => $this->roleId]);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPermissions = $this->permissions->pluck('name')->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }


    public function render()
    {
        return view('livewire.team.roles.give-permission');
    }
}
