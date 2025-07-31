<?php

namespace App\Livewire\Team\Employees;

use App\Livewire\BaseComponent;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
class Form extends BaseComponent
{

    public $name;
    public $email;
    public $address;
    public $password;
    public $id;
    public $isEdit = false;
    public $website;
    public $postcode;
    public $phone;
    public $id_role;
    public $object;

    public $roles;
    public $id_current_user;

    public $disableStore=true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|lowercase|email|max:255|',
        'password' => 'required',
        'id_role' => 'required',
    ];

    public function roleChanged()
    {
        if ($this->id_role){
            $role = Role::findById($this->id_role);

            if ($role) {
                $name = $role->name;

            }
        }else{
            $this->disableStore=true;
        }



    }

    public function mount($employee = null)
    {

        $user = auth()->user(); // Παίρνεις τον συνδεδεμένο χρήστη

        if ($user->hasRole('super-admin')) {

            $this->roles = Role::all();
        } else {

            $this->roles = Role::where('name', '!=', 'super-admin')->get();
        }



        $this->id_current_user = auth()->id();

        if ($employee) {
            $employee          = User::findOrFail($employee);
            $this->object      = $employee;
            $this->name        = $employee->name;
            $this->email       = $employee->email;
            $this->isEdit      = true;

            $this->id          = $employee->id;
            if ($employee->roles->isNotEmpty())
            {
                $this->id_role = $employee->roles->first()->id;
                if ($employee->roles->first()->name == 'super-admin') {
                    $this->disableStore = true;

                }else{
                    $this->disableStore = false;
                }
            }
        }
    }


    public function save()
    {
        if ($this->isEdit) {

            $this->rules['email'] = 'required|string|lowercase|email|max:255';
            $this->rules['password'] = 'nullable';

        } else {
            $this->rules['email'] = 'required|string|lowercase|email|max:255|unique:users,email';
        }


        $this->validate();
        // When editing, we make sure to set the ID to the existing user's ID
        if ($this->isEdit) {
            $employee = User::findOrFail($this->id);
            $role = Role::find($this->id_role); // Βρες τον ρόλο



            $employee->fill([
                'name'           => $this->name,
                'email'          => $this->email,
                'password'       => $this->password ? Hash::make($this->password) : $employee->password,
                'superadmin' => ($role->name == 'super-admin') ? true : false,

            ]);
            $employee->save(); // Save the user to the database
            if ($this->id_role) {
                $role = Role::find($this->id_role);
                if ($role) {
                    $employee->syncRoles([$role->name]); // Αφαιρεί όλους τους προηγούμενους και προσθέτει το νέο
                }
            }

        } else {
            $employee = new User();
            $role                     = Role::find($this->id_role);
            $employee->name           = $this->name;
            $employee->email          = $this->email;
            $employee->password       = Hash::make($this->password);
            $employee->superadmin = ($role->name == 'super-admin') ? true : false;
            $employee->save();
            if ($employee && $role) {
                $employee->assignRole($role->name); // Προσθήκη ρόλου
            }
        }


        $this->id = $employee->id;

        // Reset the form if it's a new user
        if (!$this->isEdit) {
            $this->reset();
        }
        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));



        return redirect()->route('employee.edit', ['employee' => $employee->id]);
    }

    public function render()
    {
        return view('livewire.team.employees.form');
    }
}
