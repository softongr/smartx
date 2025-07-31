<?php

namespace App\Livewire\Settings\Generally;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class Index extends Component
{

    public string $activeTab = 'generally';
    public string $app_name;
    public string $email_notification;
    public bool $notify_on_login;
    public bool $notify_on_login_sms;
    public bool $notify_on_login_email;

    protected array $rules = [
        'email_notification' => 'required|email'
    ];

    public function mount()
    {
        $this->app_name                 = Setting::get('app_name','');
        $this->email_notification       = Setting::get('email_notification','');
        $this->notify_on_login          = (bool) Setting::get('notify_on_login', false);
        $this->notify_on_login_sms      = (bool) Setting::get('notify_on_login_sms', false);
        $this->notify_on_login_email    = (bool) Setting::get('notify_on_login_email', false);
    }

    public function render()
    {
        return view('livewire.settings.generally.index');
    }

    public function save()
    {
        $this->validate();
        $oldAppName = Setting::get('app_name');
        Setting::set('app_name'             , $this->app_name);
        Setting::set('email_notification'   , $this->email_notification);
        Setting::set('notify_on_login', $this->notify_on_login);
        Setting::set('notify_on_login_sms', $this->notify_on_login_sms);
        Setting::set('notify_on_login_email', $this->notify_on_login_email);



        session()->flash('success',  __('Saved successfully!'));
        return redirect()->route('settings');
    }




    public function toggleNotifyOnLogin()
    {

       $this->notify_on_login = (bool) $this->notify_on_login;
        if (!$this->notify_on_login) {
            $this->notify_on_login_sms = false;
            $this->notify_on_login_email = false;
        }
    }
}
