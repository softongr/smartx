<?php

namespace App\Livewire\Synchronization\Logs;

use App\Models\SyncBatch;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class View extends Component
{
    public $object;

    public $search;
    use WithPagination;

    public function mount($id=null)
    {
        if (!isEnableLogSync()){
            return redirect()->route('synchronization.logs.index');
        }
        if ($id){
            $this->object = SyncBatch::find($id);
        }
    }
    public function render()
    {
        $query = $this->object?->logs() ?? SyncLog::query();
        if (!empty($this->search)) {
            $query->where('message', 'LIKE', '%' . $this->search . '%');
        }
        $items = $query->latest()->paginate(10);
        return view('livewire.synchronization.logs.view',[
            'items' => $items,
            'count' => $query->count(),
        ]);
    }
}
