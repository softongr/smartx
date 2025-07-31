<?php

namespace App\Livewire\Synchronization\Logs;

use App\Models\SyncBatch;
use App\Models\SyncChange;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{

    public $search;

    use WithPagination;
    use WithoutUrlPagination;

    public function render()
    {

     $items = SyncBatch::when(trim($this->search),
            function ($query, $search) {
                $query->where('entity_type', 'LIKE', '%' . $search . '%');
                $query->orWhere('action', 'LIKE', '%' . $search . '%');
            })->latest()->paginate(10);

        return view('livewire.synchronization.logs.index',[
            'items' => $items,
            'count' => SyncBatch::all()->count(),
        ]);
    }

    public function clearAll()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('sync_changes')->truncate();
        DB::table('sync_batches')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        session()->flash('success', __('Deleted!'));
        return redirect()->route('synchronization.logs.index');
    }
}
