<?php

namespace App\Livewire\OpenAi\Mapper;

use App\Models\OpenaiPrompt;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Product extends Component
{
    public array $productPromptFieldMapping = [];
    public array $productFields = [];
    public $productPrompts;



    public function mount()
    {
        $this->productPromptFieldMapping = json_decode(
            Setting::get('openai_product_prompt_field_mapping', '{}'),
            true
        ) ?? [];
        $this->productPrompts = OpenaiPrompt::where('target_model', 'product')->get();
        $this->productFields = Schema::getColumnListing('products');
    }



    public function render()
    {
        return view('livewire.open-ai.mapper.product');
    }

    public function save()
    {
        $validPromptIds = $this->productPrompts->pluck('id')->toArray();
        $validMapping = [];
        foreach ($this->productPromptFieldMapping as $promptId => $field) {
                if (in_array((int)$promptId, $validPromptIds) && in_array($field, $this->productFields)) {
                $validMapping[$promptId] = $field;
            }
        }

        Setting::set('openai_product_prompt_field_mapping', json_encode($validMapping));
        $this->productPromptFieldMapping = $validMapping;
        session()->flash('success',  __('Saved successfully!'));
        return redirect()->route('openai.mapper.product');
    }
}
