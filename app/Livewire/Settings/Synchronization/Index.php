<?php

namespace App\Livewire\Settings\Synchronization;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
class Index extends Component
{
    public string $activeTab = 'synchronization';
    public $shop_platform = 'prestashop'; // default

    public $notify_on_product_sync=0;
    public $notify_on_category_sync=0;
    public $notify_on_order_sync=0;
    public $notify_on_carrier_sync=0;
    public $notify_syn_custom_email;
    public $notify_sync_email;
    public $shop_link;
    public $sync_per_page;
    public $shop_api_key;

    public $sync_log_enabled=false;



    public function mount()
    {
        $this->notify_on_product_sync = (bool) Setting::get('notify_on_product_sync', false);
        $this->notify_on_category_sync = (bool) Setting::get('notify_on_category_sync', false);
        $this->notify_on_order_sync = (bool) Setting::get('notify_on_order_sync', false);
        $this->sync_per_page = Setting::get('sync_per_page', 50);
        $this->notify_syn_custom_email = (bool) Setting::get('notify_syn_custom_email', false);
        $this->notify_sync_email = Setting::get('notify_sync_email', '');
        $this->shop_link = Setting::get('shop_link', '');
        $this->shop_api_key = Setting::get('shop_api_key', '');
        $this->notify_on_carrier_sync = (bool) Setting::get('notify_on_carrier_sync', false);
        $this->sync_log_enabled = (bool) Setting::get('sync_log_enabled', false);
        $this->shop_platform = Setting::get('shop_platform', 'prestashop');

    }

    public function save()
    {

        $this->shop_link = rtrim($this->shop_link, '/') . '/';

        $rules = [
            'shop_link' => [
                'required',
                'url',
                'regex:/^https?:\/\/[^\/]+\/$/',
            ],
            'shop_platform' => ['required', 'in:prestashop,woocommerce,opencart,magento,cscart'],
            'shop_api_key' => ['required'],
            'sync_per_page' => ['required','numeric','min:1'],
        ];


        if ($this->notify_syn_custom_email) {
            $rules['notify_sync_email'] = ['required', 'email'];
        } else {
            $this->notify_sync_email = '';
        }

        $this->validate($rules);
        Setting::set('notify_on_product_sync', $this->notify_on_product_sync);
        Setting::set('notify_on_category_sync', $this->notify_on_category_sync);
        Setting::set('notify_on_order_sync', $this->notify_on_order_sync);
        Setting::set('notify_sync_email', $this->notify_sync_email);
        Setting::set('notify_syn_custom_email' , $this->notify_syn_custom_email);
        Setting::set('sync_per_page', $this->sync_per_page);
        Setting::set('shop_link' , $this->shop_link);
        Setting::set('shop_api_key' , $this->shop_api_key);
        Setting::set('notify_on_carrier_sync', $this->notify_on_carrier_sync);
        Setting::set('sync_log_enabled', $this->sync_log_enabled);
        Cache::forget('shop_api_authenticated');
        Setting::set('shop_platform', $this->shop_platform);

        session()->flash('success',  __('Saved successfully!'));
        return redirect()->route('settings.synchronization.index');
    }

    public function render()
    {
        return view('livewire.settings.synchronization.index');
    }

    public function toggleCustomMail()
    {
        $this->notify_syn_custom_email = (bool) $this->notify_syn_custom_email;
        if (!$this->notify_syn_custom_email) {
            $this->notify_sync_email = '';
        }
    }
}
