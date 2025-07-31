<?php

namespace App\Livewire\Settings\OpenAi;

use App\Models\OpenaiPrompt;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class Index extends Component
{
    public string $activeTab = 'openai';
    public $openai_api_key;
    public $openai_organization;
    public $openai_model;
    public $openai_max_tokens = 1024;
    public $openai_auto_apply_prompts = false;
    public $show_prompt_mapping_fields = false;
    public $openai_temperature = 0.7;
    public $openai_default_language = 'el';
    public $openai_prompt_debug = false;




    public array $productPromptFieldMapping = [];
    public array $productFields = [];
    public $productPrompts;

    public array $available_models = [
        'gpt-4o' => 'GPT-4 Omni (gpt-4o)',
        'gpt-4-turbo' => 'GPT-4 Turbo',
        'gpt-4' => 'GPT-4',
        'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        'gpt-3.5-turbo-16k' => 'GPT-3.5 Turbo 16k',
    ];

    protected $rules = [
        'openai_api_key' => 'required|string',
        'openai_organization' => 'nullable|string',
        'openai_model' => 'required|string',
        'openai_max_tokens' => 'nullable|integer|min:1',
        'openai_temperature' => 'nullable|numeric|between:0,2',
        'openai_default_language' => 'nullable|string|in:el,en',
        'openai_prompt_debug' => 'nullable|boolean',
    ];
    public function mount()
    {
        $this->openai_api_key         = Setting::get('openai_api_key', '');
        $this->openai_organization    = Setting::get('openai_organization', '');
        $this->openai_model           = Setting::get('openai_model', 'gpt-4o');
        $this->openai_max_tokens      = Setting::get('openai_max_tokens', 1024);
        $this->openai_temperature     = Setting::get('openai_temperature', 0.7);
        $this->openai_default_language = Setting::get('openai_default_language', 'el');
        $this->openai_prompt_debug = (bool) Setting::get('openai_prompt_debug', false);
        $this->openai_auto_apply_prompts = (bool) Setting::get('openai_auto_apply_prompts', false);


        if ($this->openai_auto_apply_prompts) {
            $this->productPromptFieldMapping = json_decode(
                Setting::get('openai_product_prompt_field_mapping', '{}'),
                true
            ) ?? [];

            $this->productPrompts = OpenaiPrompt::where('target_model', 'product')->get();
            $this->productFields = Schema::getColumnListing('products');
            $this->show_prompt_mapping_fields = true;
        }

    }

    public function render()
    {

        return view('livewire.settings.open-ai.index');
    }

    public function save()
    {
        $this->validate();

        Setting::set('openai_api_key', $this->openai_api_key);
        Setting::set('openai_organization', $this->openai_organization);
        Setting::set('openai_model', $this->openai_model);
        Setting::set('openai_max_tokens', $this->openai_max_tokens);
        Setting::set('openai_temperature', $this->openai_temperature);
        Setting::set('openai_default_language', $this->openai_default_language);
        Setting::set('openai_prompt_debug', $this->openai_prompt_debug);

        Setting::set('openai_auto_apply_prompts', $this->openai_auto_apply_prompts);

        if ($this->openai_auto_apply_prompts) {
            Setting::set('openai_product_prompt_field_mapping', json_encode($this->productPromptFieldMapping));

            // ✅ Φόρτωσε ξανά τα prompts/fields για να εμφανιστούν
            $this->productPrompts = OpenaiPrompt::where('target_model', 'product')->get();
            $this->productFields = Schema::getColumnListing('products');
            $this->show_prompt_mapping_fields = true;
        } else {
            Setting::set('openai_product_prompt_field_mapping', json_encode([]));
            $this->productPrompts = collect(); // κενό
            $this->productFields = [];
            $this->show_prompt_mapping_fields = false;
        }

        session()->flash('success',  __('Saved successfully!'));

        return redirect()->route('settings.openai.index');
    }

    public function togglePromptAutoload()
    {
        $this->openai_auto_apply_prompts = !$this->openai_auto_apply_prompts;

        if ($this->openai_auto_apply_prompts) {
            $this->productPrompts = OpenaiPrompt::where('target_model', 'product')->get();
            $this->productFields = Schema::getColumnListing('products');

            $this->productPromptFieldMapping = json_decode(
                Setting::get('openai_product_prompt_field_mapping', '{}'),
                true
            ) ?? [];
        }

        $this->show_prompt_mapping_fields = $this->openai_auto_apply_prompts;
    }
}
