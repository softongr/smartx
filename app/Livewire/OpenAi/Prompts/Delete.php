<?php

namespace App\Livewire\OpenAi\Prompts;

use App\Models\OpenaiPrompt;
use Livewire\Component;

class Delete extends Component
{
    public function mount($prompt=null)
    {
        if ($prompt) {
            $item =OpenaiPrompt::findOrFail($prompt);
            $item->delete();
            session()->flash('success',  __('Deleted Successfully'));
            return redirect()->route('openai.prompts.index');
        }
    }

}
