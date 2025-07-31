<?php

namespace App\Livewire\OpenAi\Prompts;

use App\Models\Marketplace;
use App\Models\OpenaiPrompt;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $search;
    use WithPagination;

    public function render()
    {
        $items = OpenaiPrompt::where('name',
                        'LIKE', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.open-ai.prompts.index', [
            'items' => $items,
            'count' => OpenaiPrompt::all()->count()]
        );
    }
}
