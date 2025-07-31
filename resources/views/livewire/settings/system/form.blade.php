@php
    $tools = [
        'route_clear'    => 'Clear Routes',
        'view_clear'     => 'Clear Views',
        'cache_clear'    => 'Clear Cache',
        'config_clear'   => 'Clear Config',

        'route_cache'    => 'Cache Routes',
        'view_cache'     => 'Cache Views',
        'event_clear'    => 'Clear Events',
        'event_cache'    => 'Cache Events',
        'queue_restart'  => 'Restart Queues',
        'schedule_run'   => 'Run Scheduler',
        'storage_link'   => 'Create Storage Link',
    ];
@endphp



<div class="grid lg:grid-cols-2 gap-4">


        @php
            $tools = [
    'route_clear'    => 'Clear Routes',
    'view_clear'     => 'Clear Views',
    'cache_clear'    => 'Clear Cache',
    'config_clear'   => 'Clear Config',
    'config_cache'   => 'Cache Config',
    'route_cache'    => 'Cache Routes',
    'view_cache'     => 'Cache Views',
    'event_clear'    => 'Clear Events',
    'event_cache'    => 'Cache Events',
    'optimize_clear' => 'Optimize Clear (All)',
    'queue_restart'  => 'Restart Queues',
    'schedule_run'   => 'Run Scheduler',
    'storage_link'   => 'Create Storage Link',
];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($tools as $key => $label)
                <div class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="selected" value="{{ $key }}" id="{{ $key }}">
                    <label for="{{ $key }}">{{ __($label) }}</label>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button wire:click="runSelected" class="btn bg-primary text-white px-4 py-2">
                {{ __('Εκτέλεση Επιλεγμένων') }}
            </button>
        </div>

</div>
