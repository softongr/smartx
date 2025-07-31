<?php

namespace App\Livewire\Settings\Smtp;

use App\Mail\TestEmail;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;


class Index extends Component
{

    public string $activeTab = 'smtp';

    public $mail_mailer = 'smtp';
    public $test_email = '';
    public $mail_host;
    public $mail_port = 587;
    public $mail_username;
    public $mail_password;
    public $mail_encryption = 'tls';
    public $mail_from_address;
    public $mail_from_name;


    protected $rules = [
        'mail_mailer' => 'required|string',
        'mail_host' => 'required|string',
        'mail_port' => 'required|numeric',
        'mail_username' => 'required|string',
        'mail_password' => 'required|string',
        'mail_encryption' => 'nullable|string',
        'mail_from_address' => 'required|email',
        'mail_from_name' => 'required|string',
    ];


    public function mount()
    {
        $this->mail_mailer = Setting::get('mail_mailer', 'smtp');
        $this->mail_host = Setting::get('mail_host');
        $this->mail_port = Setting::get('mail_port', 587);
        $this->mail_username = Setting::get('mail_username');
        $this->mail_password = Setting::get('mail_password');
        $this->mail_encryption = Setting::get('mail_encryption', 'tls');
        $this->mail_from_address = Setting::get('mail_from_address');
        $this->mail_from_name = Setting::get('mail_from_name');
    }

    public function save()
    {
        $this->validate();
        Setting::set('mail_mailer', $this->mail_mailer);
        Setting::set('mail_host', $this->mail_host);
        Setting::set('mail_port', $this->mail_port);
        Setting::set('mail_username', $this->mail_username);
        Setting::set('mail_password', $this->mail_password);
        Setting::set('mail_encryption', $this->mail_encryption);
        Setting::set('mail_from_address', $this->mail_from_address);
        Setting::set('mail_from_name', $this->mail_from_name);
        session()->flash('success',  __('Saved successfully!'));

        return redirect()->route('settings.smtp.index');
    }

    public function render()
    {
        return view('livewire.settings.smtp.index');
    }

    public function sendTestEmail()
    {
        $this->validate([
            'test_email' => 'required|email',
        ]);
        try {
            if (Setting::smtpConfigReady()) {
                Mail::to($this->test_email)->send(new TestEmail('This is a test email from your Laravel app.'));
                session()->flash('success', __('Test email sent successfully!'));

            }else{
                session()->flash('error', __('Missing Configuration'));
            }

        } catch (\Exception $e) {
            session()->flash('error', __('Failed to send test email: ') . $e->getMessage());
        }

        return redirect()->route('settings.smtp.index');
    }
}
