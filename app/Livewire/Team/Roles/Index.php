<?php

namespace App\Livewire\Team\Roles;

use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search;


    protected $updatesQueryString = ['search'];
    public function updatedSearch()
    {
        $this->resetPage(); // Επαναφέρει το pagination στην πρώτη σελίδα κάθε φορά που αλλάζει η αναζήτηση
    }

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->search . '%')->latest()->paginate(10);
        return view('livewire.team.roles.index',[
            'items' => $roles,
            'count' => Role::all()->count(),
        ]);
    }

    public function delete($id){
        LivewireAlert::title(__('Are you sure?'))
            ->withConfirmButton(__('Yes, delete it!'))
            ->withCancelButton(__('No, Cancel'))
            ->onConfirm('deleteData', ['id' => $id])
            ->show();
    }

    public function deleteData($id)
    {
        $role = Role::findOrFail($id['id']);
        $usersWithRole = User::role($role->name)->get();
        // Αν υπάρχουν χρήστες με αυτό το ρόλο και είναι ο μόνος χρήστης με αυτό το ρόλο
        if ($usersWithRole->count() == 1) {
            // Διαγράφουμε και τον χρήστη
            $usersWithRole->first()->delete();
        }
        $role->delete();

        LivewireAlert::title(__('Deleted!'))
            ->text(__('Item has been successfully deleted!'))
            ->success()
            ->timer(2000) // Dismisses after 3 seconds
            ->show();
    }

}
