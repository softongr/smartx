<?php

namespace App\Livewire\OpenAi\Prompts;

use App\Models\OpenaiPrompt;
use Livewire\Component;

class Form extends Component
{
    public $id = 0;
    public $target_model;
    public $name;
    public $type;
    public $language = 'el';
    public $system_prompt;
    public $user_prompt_template;

    public $object;

    public $isEdit = false;

    public $typeOptions = [
        'meta_title' => 'Meta title',
        'meta_description' => 'Meta Description',
        'description_short' => 'Description Short',
        'description' => 'Description',
        'features' => 'Features',
    ];

    public array $allowedPlaceholders = [
        'name',
        'features',
        'meta_title',
        'meta_description',
    ];


    public function mount($prompt = null)
    {
        if ($prompt) {
            $this->object = OpenaiPrompt::findOrFail($prompt);
            $this->target_model = $this->object->target_model;
            $this->id = $this->object->id;
            $this->name = $this->object->name;
            $this->type = $this->object->type;
            $this->language = $this->object->language;
            $this->system_prompt = $this->object->system_prompt;
            $this->user_prompt_template = $this->object->user_prompt_template;
            $this->isEdit = true;
        }

    }

    public function render()
    {
        return view('livewire.open-ai.prompts.form', [
            'placeholders' => collect($this->allowedPlaceholders)
                ->map(fn($p) => '<code>{{' . $p . '}}</code>')
                ->implode(', ')
        ]);
    }


    public function save()
    {
        $rules = [
            'name' => 'required',
            'target_model' => 'required|in:product,category',
            'type' => 'required|in:meta_title,meta_description,description_short,description,features',
            'language' => 'required',
            'system_prompt' => 'required',
            'user_prompt_template' => ['required', 'regex:/\{\{\s*\w+\s*\}\}/'], // πρέπει να έχει {{placeholder}}
        ];

        $messages = [
            'user_prompt_template.regex' => __('Το prompt πρέπει να περιέχει τουλάχιστον ένα placeholder π.χ. {{name}}'),
        ];


        $this->validate($rules);


        $exists = OpenaiPrompt::where('target_model', $this->target_model)
            ->where('type', $this->type)
            ->where('language', $this->language);

        if ($this->isEdit) {
            $exists->where('id', '!=', $this->id);
        }

        if ($exists->exists()) {
            $this->addError('type', __('Ήδη υπάρχει prompt με αυτόν τον τύπο για το επιλεγμένο μοντέλο και γλώσσα.'));
            return;
        }

        // Έλεγχος αν όλα τα placeholders είναι επιτρεπτά
        preg_match_all('/\{\{\s*(\w+)\s*\}\}/', $this->user_prompt_template, $matches);
        $usedPlaceholders = $matches[1] ?? [];

        foreach ($usedPlaceholders as $placeholder) {
            if (!in_array($placeholder, $this->allowedPlaceholders)) {
                $this->addError('user_prompt_template', __('Μη έγκυρο placeholder: ') . '{{' . $placeholder . '}}');
                return;
            }
        }

        $fields = [

            'name' => $this->name,
            'target_model' => $this->target_model,
            'type' => $this->type,
            'language' => $this->language,
            'system_prompt' => $this->system_prompt,
            'user_prompt_template' => $this->user_prompt_template,
        ];


        if ($this->isEdit) {
            $item = OpenaiPrompt::findOrFail($this->id);
            $item->fill($fields);
            $item->save();
        } else {
            $item = OpenaiPrompt::create($fields);
        }


        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));


        return redirect()->route('openai.prompts.edit', ['prompt' => $item->id]);

    }


    public function onTargetModelChanged()
    {
        if ($this->target_model === 'category' && $this->type === 'features') {
            $this->type = null;
        }
    }
}
