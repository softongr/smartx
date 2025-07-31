<?php

namespace App\Livewire\Settings\System;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Illuminate\Support\Facades\Artisan;

class Index extends Component
{
    public string $activeTab = 'performance';

    public array $selected = [];


    public function runSelected()
    {
        $commands = [
            'route_clear'    => 'route:clear',
            'view_clear'     => 'view:clear',
            'cache_clear'    => 'cache:clear',
            'config_clear'   => 'config:clear',
            'config_cache'   => 'config:cache',
            'route_cache'    => 'route:cache',
            'view_cache'     => 'view:cache',
            'event_clear'    => 'event:clear',
            'event_cache'    => 'event:cache',
            'optimize_clear' => 'optimize:clear',
            'queue_restart'  => 'queue:restart',
            'schedule_run'   => 'schedule:run',
            'storage_link'   => 'storage:link',
        ];
        $executed = [];

        foreach ($this->selected as $key) {
            if (isset($commands[$key])) {
                Artisan::call($commands[$key]);
                $executed[] = $commands[$key];
            }
        }


        if (count($executed)) {
            session()->flash('success', 'Executed: ' . implode(', ', $executed));
        } else {
            session()->flash('error', 'No commands selected.');
        }

        $this->selected = []; // reset μετά
        return redirect()->route('settings.performance.index');
    }





    public function render()
    {
        return view('livewire.settings.system.index');
    }
}
