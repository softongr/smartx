<?php

namespace App\Livewire\Settings\Api;

use App\Models\Setting;

use Livewire\Component;
use Illuminate\Support\Str;

class Index extends Component
{

    public string $activeTab = 'api_token';
    public string $system_api_key;

    protected array $rules = [
        'system_api_key' => 'required',
    ];

    public function mount(){
        $this->system_api_key = Setting::get('system_api_key', '');
    }
    public function render()
    {
        return view('livewire.settings.api.index');
    }

    public function save()
    {



        if (empty($this->system_api_key)) {
            $this->system_api_key = Str::uuid()->toString(); // ή Str::random(32) αν θες απλό random string
        }
        $this->validate();
        Setting::set('system_api_key'   ,  $this->system_api_key);

        session()->flash('success',  __('Saved successfully!'));
        return redirect()->route('settings.api_token.index');
    }

}
