<?php

namespace App\Livewire\Settings\MyAADE;

use App\Models\Setting;

use Livewire\Component;

class Index extends Component
{
    public string $activeTab = 'myaade';




    public $aade_username;
    public $aade_password;
    public $test_vat_number;

    protected $rules = [
        'aade_username' => 'required',
        'aade_password' => 'required',

    ];

    public function mount()
    {
        $this->aade_username = Setting::get('aade_username', '');
        $this->aade_password = Setting::get('aade_password', '');
    }

    public function render()
    {

        return view('livewire.settings.my-a-a-d-e.index');
    }

    public function save()
    {
        $this->validate();
        Setting::set('aade_username', $this->aade_username);
        Setting::set('aade_password', $this->aade_password);

        session()->flash('success',  __('Saved successfully!'));

        return redirect()->route('settings.myaade.index');

    }

    public function testMyAADE()
    {

        $this->validate([
            'test_vat_number' => ['required', 'regex:/^\d{9}$/'],

        ]);

        $aade = new \App\Services\AadeAfmService($this->aade_username, $this->aade_password);
        $info = $aade->info($this->test_vat_number);

        if(!$info['success']){
            session()->flash('error',  $info['reason']);
        }else{
            session()->flash('success', $info['business']['onomasia']);
        }

        return redirect()->route('settings.myaade.index');
    }
}
