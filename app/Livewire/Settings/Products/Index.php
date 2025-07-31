<?php

namespace App\Livewire\Settings\Products;

use App\Models\Marketplace;
use App\Models\Setting;
use Livewire\Component;

class Index extends Component
{

    public $default_quantity =1;
    public $default_minimum_profit =0;
    public $openai_auto_apply_prompts=0;
    public string $activeTab = 'products';
    public $default_marketplace_for_add_product =0;

    public $scrape_log_enabled=0;
    public $markets;
    public $income_tax;


    protected array $rules = [
        'default_quantity' => 'required|integer|min:1',
        'default_minimum_profit' => 'required|numeric|between:1,100|max:100|regex:/^\d{1,3}(\.\d{1,2})?$/',
        'income_tax' => 'required|numeric|between:1,100|max:100|regex:/^\d{1,3}(\.\d{1,2})?$/',
    ];

    public function mount()
    {
        $this->markets = Marketplace::all();
        $this->default_quantity = Setting::get('default_quantity', 1);
        $this->default_minimum_profit = Setting::get('default_minimum_profit', 0);
        $this->openai_auto_apply_prompts = (bool) Setting::get('openai_auto_apply_prompts', false);
        $this->default_marketplace_for_add_product = Setting::get('default_marketplace_for_add_product', false);
        $this->scrape_log_enabled = Setting::get('scrape_log_enabled', false);
        $this->income_tax = Setting::get('income_tax', 0);

    }
    public function render()
    {
        return view('livewire.settings.products.index');
    }


    public function save()
    {
        $this->validate();
        Setting::set('default_quantity'   , $this->default_quantity);
        Setting::set('default_minimum_profit' , $this->default_minimum_profit);
        Setting::set('openai_auto_apply_prompts', $this->openai_auto_apply_prompts);
        Setting::set('default_marketplace_for_add_product', $this->default_marketplace_for_add_product);
        Setting::set('scrape_log_enabled', $this->scrape_log_enabled);
        Setting::set('income_tax', $this->income_tax);
        session()->flash('success',  __('Saved successfully!'));
        return redirect()->route('settings.products.index');
    }
}
