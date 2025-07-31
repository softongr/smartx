<?php

namespace App\Livewire\Team\Logs;

use App\Models\UserLogin;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search;

    public function render()
    {

        $query = UserLogin::with('user') // για το όνομα χρήστη
        ->when($this->search, function ($q) {
            $q->where(function ($subQuery) {
                $subQuery->where('ip_address', 'like', '%' . $this->search . '%')
                    ->orWhere('country', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%')
                    ->orWhere('region', 'like', '%' . $this->search . '%')
                    ->orWhere('zip', 'like', '%' . $this->search . '%')
                    ->orWhere('user_agent', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            });
        })
            ->orderByDesc('created_at');

        return view('livewire.team.logs.index',[
            'items' => $query->paginate(10),
            'count' => UserLogin::all()->count(),
        ]);
    }
}
