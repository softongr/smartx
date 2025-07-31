<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Accessibility</i>
                    {{ __('Logs') }}
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-indigo-500 text-white rounded me-1">{{$count}}</span>
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->


        @if(!is_sync_running() && $count)
            <div class="flex justify-end">
                <button wire:click="clearAll" class="btn rounded-full bg-dark/25 text-slate-900 hover:bg-dark hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                     {{ __('Trash Your History') }}
                </button>
            </div>
        @endif

    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->

    <div wire:poll.500ms>
        @include('livewire._partials.sync_running')
        <div class="card overflow-hidden p-6">

            @if($count)
                <div class="flex mb-5">
                    @include('livewire._partials.search')
                </div>
            @endif

            @include('livewire._partials.messages.success')
            @include('livewire._partials.messages.error')

            @if(count($items))
                @include('livewire.synchronization.logs._partials.data')
            @else
                @include('livewire._partials.nodata' ,['url' => ''])
            @endif

            @if(count($items))
                <div class="mt-5 bg-white">
                    {{$items->links()}}
                </div>
            @endif

           @include('livewire._partials.loading' , ['text' => __('Process'), 'events' => 'clearAll'])
        </div><!-- card overflow-hidden p-6-->
    </div>
</div>


