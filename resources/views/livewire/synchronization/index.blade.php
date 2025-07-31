<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>

                    {{ __('Synchronization') }}
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->
    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->

    <div  wire:poll.500ms>

        @include('livewire._partials.sync_running')
        @include('livewire._partials.messages.success')
        @include('livewire._partials.messages.error')



        <div class="mb-4 flex justify-between gap-2">
            @include('livewire._partials.log_sync')

            @if(is_api_authenticated())
            <button
                wire:click="startFullSync"
                @if($this->isAnySyncRunning()) disabled @endif
                class="btn rounded-full bg-dark/25 text-slate-900 hover:bg-dark hover:text-white">
                @if($this->isAnySyncRunning())
                    <div class="animate-spin w-6 h-6 border-[3px] border-current border-t-transparent text-default-900 rounded-full"
                         role="status" aria-label="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                    {{ __('Wait.....') }}

                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    {{ __('Synchronize All') }}
                @endif
            </button>
            @endif
        </div>



        @if(is_api_authenticated())
            <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
                @foreach($entityTypes as $type)
                    @include('livewire.synchronization.entries.entity', ['type' => $type])
                @endforeach
            </div>
        @else
            @include('livewire._partials.api_authenticated')
        @endif

    </div>

    @include('livewire._partials.loading' , ['text' => __('Process'), 'events' => 'startSync,startFullSync'])
</div>








