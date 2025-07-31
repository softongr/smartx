
@php
    use Carbon\CarbonInterval;

    $s = $object?->duration_seconds ?? 0;

    $durationText = CarbonInterval::seconds($s)
        ->cascade()
        ->locale(app()->getLocale()) // 'el' ή 'en'
        ->forHumans([
            'join' => true, // π.χ. "2 λεπτά και 3 δευτερόλεπτα"
            'parts' => 2,   // max πόσα μέρη να δείξει
            'short' => false
        ]);
@endphp



<div>
    <div class="card overflow-hidden p-6">

        <div class="flex items-center justify-between gap-1">
            <div class="flex">
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-500 text-white">
                    {{ $object->type }}
                </span>
                <div>
                    {{ __('Date Batch') }}
                    {{ $object->type }}
                </div>
            </div>

            <div class=" flex gap-2 items-center gap-2">

                |
                <div class="flex items-center justify-start gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <div class="flex flex-col">
                        <strong class="text-black">{{ __('Duration') }}</strong>
                        <i class="text-xs">{{$durationText}}</i>
                    </div>

                </div>

            </div>
        </div>

    </div>


    <div class="card overflow-hidden p-6 mt-2" wire:poll.500ms>
        @include('livewire._partials.sync_running')
        @if(count($items))
            @include('livewire.synchronization.logs._partials.view')
        @else
            @include('livewire._partials.nodata' ,['url' => ''])
        @endif

        @if(count($items))
            <div class="mt-5 bg-white">
                {{$items->links()}}
            </div>
        @endif
    </div>
</div>
