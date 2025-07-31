<div wire:poll.500ms>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Store</i>
                    {{ __('Monitors ') }}

                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->




    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->

    <div class="card overflow-hidden p-6">
        @include('livewire._partials.sync_running')





            @include('livewire.monitors._partials.data')


        @if(count($items))
            <div class="mt-5 bg-white">
                {{$items->links()}}
            </div>
        @endif
    </div><!-- card overflow-hidden p-6-->
</div>
