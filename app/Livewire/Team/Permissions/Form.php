<?php

namespace App\Livewire\Team\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Form extends Component
{
    public $name;
    public $isEdit = false;
    public $object;
    public $id;
    protected $rules = [
        'name' => 'required|string|max:255|unique:'.Permission::class,
    ];


    public function mount($permission = null)
    {
        if($permission){
            $permission = Permission::findById($permission);
            $this->object = $permission;
            $this->name = $permission->name;
            $this->isEdit = true;
            $this->id = $permission->id;
        }
    }

    public function render()
    {
        return view('livewire.team.permissions.form');
    }


    public function save()
    {
        if ($this->isEdit) {
            $this->rules['name'] = 'required|string|max:255|unique:permissions,name,' . $this->id;
        } else {
            $this->rules['name'] = 'required|string|max:255|unique:permissions,name';
        }


        $this->validate();
        $fields = [
            'name'       => $this->name,
            'guard_name' => 'web',
        ];

        if ($this->isEdit) {
            $role = Permission::findOrFail($this->id);
            $role->fill($fields);
            $role->save();
        } else {
            $role       = new Permission();
            $role->name = $this->name;
            $role->guard_name = 'web';
            $role->save();
        }

        $this->id = $role->id;
        if (!$this->isEdit) {
            $this->reset();
        }
        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));
        return redirect()->route('permissions.edit', ['permission' => $role->id]);
    }

}
