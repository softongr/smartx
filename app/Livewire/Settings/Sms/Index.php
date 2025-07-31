<?php

namespace App\Livewire\Settings\Sms;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    public string $activeTab = 'sms';

    public $sms_store_name='';
    public $sms_api_key ='';
    public $test_phone_number;

    public $admin_phone_number;

    protected array $rules = [
        'sms_store_name' => 'required',
        'sms_api_key' => 'required',
        'admin_phone_number' => 'required|regex:/^69\d{8}$/',
    ];

    public function mount()
    {
        $this->sms_store_name       = Setting::get('sms_store_name', '');
        $this->sms_api_key          = Setting::get('sms_api_key', '');
        $this->admin_phone_number   = Setting::get('admin_phone_number', '');
    }

    public function render()
    {
        return view('livewire.settings.sms.index');
    }

    public function save()
    {
        $this->validate();
        Setting::set('sms_store_name'   ,  $this->sms_store_name);
        Setting::set('sms_api_key' ,        $this->sms_api_key);
        Setting::set('admin_phone_number' , $this->admin_phone_number);
        session()->flash('success',  __('Saved successfully!'));

        return redirect()->route('settings.sms.index');
    }


    public function testSms()
    {
        $this->validate([
            'test_phone_number' => ['required', 'regex:/^69\d{8}$/'], // ή ό,τι pattern θες
        ]);

        $data = [
            'key'  => $this->sms_api_key, // αποθηκεύεις στο .env
            'text' => 'Hello from Laravel!',
            'from' => $this->sms_store_name,
            'to'   => $this->test_phone_number,
            'type' => 'json',
        ];
        $smsService = app(\App\Services\SmsService::class);
        $response = $smsService->send($data);

        if (isset($response['status']) && $response['status'] === '1') {
            session()->flash('success', $response['remarks'] ?? __('SMS sent successfully.'));
        } else {
            session()->flash('error', $response['remarks'] ?? __('SMS failed to send.'));
        }

        return redirect()->route('settings.sms.index');
    }


    /***
     * @param array $parameters
     * @return array|mixed
     */
    function sendSmsWithFailover(array $parameters)
    {
        $primary = 'https://easysms.gr/api/sms/send';
        $backup  = 'https://backup.easysms.gr/api/sms/send';

        try {
            $response = Http::asForm()
                ->timeout(1)
                ->post($primary, $parameters);

            if ($response->successful()) {
                return $response->json();
            }

            $backupResponse = Http::asForm()
                ->timeout(1)
                ->post($backup, $parameters);

            return $backupResponse->json();

        } catch (\Exception $e) {
            return ['error' => true, 'message' => __('SMS failed to send.')];
        }
    }
}
