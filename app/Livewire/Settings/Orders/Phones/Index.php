<?php

namespace App\Livewire\Settings\Orders\Phones;

use App\Models\Setting;
use Livewire\Component;

class Index extends Component
{

    public string $activeTab = 'phone_orders';
    public $cod_fee = 2;
    public $shipping_fee =3.00;
    public $free_shipping_threshold = 30.00;

    protected $rules = [
        'cod_fee' => 'required|numeric|min:0',
        'shipping_fee' => 'required|numeric|min:0',
        'free_shipping_threshold' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->cod_fee = Setting::get('cod_fee', 2);
        $this->shipping_fee = Setting::get('shipping_fee', 3);
        $this->free_shipping_threshold = Setting::get('free_shipping_threshold', 30);
    }

    public function render()
    {
        return view('livewire.settings.orders.phones.index');
    }

    public function save()
    {
        $this->validate();
        Setting::set('cod_fee', $this->cod_fee);
        Setting::set('shipping_fee', $this->shipping_fee);
        Setting::set('free_shipping_threshold', $this->free_shipping_threshold);

        session()->flash('success',  __('Saved successfully!'));

        return redirect()->route('settings.ordersphone.index');

    }
}
