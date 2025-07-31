<?php

namespace App\Livewire\OpenAi\Mapper;

use App\Models\OpenaiPrompt;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class Category extends Component
{
    public array $categoryPromptFieldMapping = [];
    public array $categoryFields= [];
    public $categoryPrompts;


    public function mount()
    {
        $this->categoryPromptFieldMapping = json_decode(
            Setting::get('openai_category_prompt_field_mapping', '{}'),
            true
        ) ?? [];
        $this->categoryPrompts = OpenaiPrompt::where('target_model', 'category')->get();
        $this->categoryFields = Schema::getColumnListing('categories');
    }

    public function render()
    {
        return view('livewire.open-ai.mapper.category');
    }

    public function save()
    {
        $validPromptIds = $this->categoryPrompts->pluck('id')->toArray();
        $validMapping = [];
        foreach ($this->categoryPromptFieldMapping as
                 $promptId => $field) {
            if (in_array((int)$promptId, $validPromptIds)
                && in_array($field, $this->categoryFields)
            ) {
                $validMapping[$promptId] = $field;
            }
        }

        Setting::set('openai_category_prompt_field_mapping', json_encode($validMapping));
        $this->categoryPromptFieldMapping = $validMapping;
        session()->flash('success',  __('Saved successfully!'));
        return redirect()->route('openai.mapper.category');
    }
}
