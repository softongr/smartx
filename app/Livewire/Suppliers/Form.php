<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Form extends Component
{
    public $name;
    public $phone;
    public $email;
    public $address;
    public $website;
    public $city;
    public $postcode;

    public $id;
    public $isEdit = false;
    public $map_url;
    public $api = false;
    public $api_type;
    public $show_api_url = false;
    public $api_url;

    public function rules()
    {
        $rules = [
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|string|email',
            'map_url'    => 'nullable|url',
            'postcode'   => 'nullable|numeric',
            'website'    => 'nullable|url',
            'city'       => 'nullable|string',
            'address'    => 'nullable|string',
        ];

        if ($this->api) {
            $rules['api_type'] = 'required|string';
        }

        if ($this->api_type !== null && $this->api_type !== '0') {
            $rules['api_url'] = 'required|url';
        }

        return $rules;
    }

    public function apiType($value)
    {
        $this->show_api_url = (bool) $value;
    }

    public function toggleApi()
    {
        if (!$this->api) {
            $this->api_type = null;
            $this->api_url = null;
            $this->show_api_url = false;
        }
    }

    public function mount($supplier = null)
    {
        if ($supplier) {
            $s = Supplier::findOrFail($supplier);

            $this->id         = $s->id;
            $this->name       = $s->name;
            $this->phone      = $s->phone;
            $this->email      = $s->email;
            $this->address    = $s->address;
            $this->city       = $s->city;
            $this->postcode   = $s->postcode;
            $this->map_url    = $s->map_url;
            $this->api        = $s->api;
            $this->api_type   = $s->api_type;
            $this->api_url    = $s->api_url;

            $this->isEdit = true;
        }
    }

    public function render()
    {
        return view('livewire.suppliers.form');
    }

    public function save()
    {
        $this->validate();

        $fields = [
            'name'       => $this->name,
            'address'    => $this->address,
            'phone'      => $this->phone,
            'email'      => $this->email,
            'website'    => $this->website,
            'city'       => $this->city,
            'postcode'   => $this->postcode,
            'map_url'    => $this->map_url,
            'api'        => $this->api,
            'api_type'   => $this->api_type,
            'api_url'    => $this->api_url,
        ];

        if ($this->isEdit && $this->id) {
            $supplier = Supplier::findOrFail($this->id);
            $supplier->fill($fields);
            $supplier->save();
        } else {
            $supplier = new Supplier();
            $supplier->fill($fields);
            $supplier->save();
        }

        $this->id = $supplier->id;

        if (!$this->isEdit) {
            $this->reset();
        }

        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));

        return redirect()->route('supplier.edit', ['supplier' => $supplier->id]);
    }
}
