<?php

namespace App\Livewire\Team\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $name;
    public $guard_name='web';
    public $isEdit = false;

    public $object;

    public $id;
    protected $rules = [
        'name' => 'required|string|max:255|unique:'.Role::class,
    ];

    public function mount($role = null)
    {
        if ($role) {

            $role = Role::findById($role);
            $this->object = $role;
            $this->name = $role->name;
            $this->isEdit = true;
            $this->id = $role->id;
        }
    }

    public function render()
    {
        return view('livewire.team.roles.form');
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->rules['name'] = 'required|string|max:255|unique:roles,name,' . $this->id;
        } else {
            $this->rules['name'] = 'required|string|max:255|unique:roles,name';
        }

        $this->validate();
        if ($this->isEdit) {
            $role = Role::findOrFail($this->id);
            $role->fill([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
            $role->save();
        } else {
            $role = new Role();
            $role->name = $this->name;
            $role->guard_name = $this->guard_name;
            $role->save();
        }

        $this->id = $role->id;
        if (!$this->isEdit) {
            $this->reset();
        }
        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));

        return redirect()->route('role.edit', ['role' => $role->id]);
    }
}
