<?php

namespace App\Livewire\Rates;

use App\Models\RateVat;
use Illuminate\Validation\Rule;

use Livewire\Component;

class Form extends Component
{

    public $id;
    public $name;
    public $rate;
    public $default=false;
    public $isEdit=false;
    public  $object;

    public function mount($rate=null)
    {
        if($rate){
            $this->object                   = RateVat::findOrFail($rate);
            $this->id                      = $this->object->id;
            $this->name                    = $this->object->name;
            $this->rate                    = $this->object->rate;
            $this->default                  = $this->object->default;

            $this->isEdit                  = true;
        }else{
            $this->default = RateVat::where('default', true)->doesntExist();
        }
    }

    public function render()
    {
        return view('livewire.rates.form');
    }

    public function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'rate'    => [
                'required',
                'numeric',
                'between:0,100', // προαιρετικά ελάχιστο
                'max:100',        // μέγιστο 100
                'regex:/^\d{1,3}(\.\d{1,2})?$/',
                 Rule::unique('rate_vats', 'rate')->ignore($this->id),
            ],
            'default' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit)
        {
            $current = RateVat::findOrFail($this->id);
            if ($current->default && !$this->default) {
                $otherDefaultExists = RateVat::where('default', true)
                    ->where('id', '!=', $this->id)
                    ->exists();

                if (!$otherDefaultExists) {
                    $this->addError('default', 'Δεν μπορείς να αφαιρέσεις το default χωρίς να υπάρχει άλλη προεπιλεγμένη εγγραφή.');
                    return;
                }
            }
        }

        if (!$this->default && RateVat::where('default', true)->count() === 0) {
            $this->default = true;
        }

        if ($this->default) {
            RateVat::where('default', true)
                ->when($this->isEdit, function ($query) {
                    // Αν είμαστε σε edit, εξαιρούμε την τρέχουσα εγγραφή
                    return $query->where('id', '!=', $this->id);
                })
                ->update(['default' => false]);
        }


        $fields = [
            'name'      => $this->name,
            'rate'      => $this->rate,
            'default'   => $this->default,
        ];


        if ($this->isEdit) {
            $item = RateVat::findOrFail($this->id);
            $item->fill($fields);
            $item->save();
        } else {
            $item = RateVat::create($fields);
        }

        $this->id = $item->id;
        if (!$this->isEdit) {
            $this->reset();
        }
        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));
        return redirect()->route('rate.edit', ['rate' => $item->id]);
    }
}
