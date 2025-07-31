<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Person</i>
                    {{ __('Permissions') }}
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-indigo-500 text-white rounded me-1">{{$count}}</span>
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- div -->

        @if($user->isSuperAdmin() || $user->can('permissions.create'))
            <div>
                <button wire:loading.attr="disabled" wire:click="synchronization" class="
                                    h-10 w-10 rounded-full bg-gray-200 flex justify-center items-center"
                        data-fc-placement="bottom">
                    <i class="material-symbols-rounded font-light text-4xl transition-all group-hover:fill-1">Backspace</i>
                </button>
                @include('livewire._partials.button_create',['text' => __('Add new'), 'url'=> route('permission.create')])

            </div>
        @endif


    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->
    <div class="card overflow-hidden p-6">
        @if($count)
            <div class="flex mb-5 gap-2 justify-start items-center">
                @include('livewire._partials.search')
                @if(!empty($search))
                    <button wire:loading.attr="disabled" wire:click="clearSearch" class="
                                    h-10 w-10 rounded-full bg-gray-200 flex justify-center items-center"
                            data-fc-placement="bottom">
                        <i class="material-symbols-rounded font-light text-4xl transition-all group-hover:fill-1">Backspace</i>
                    </button>
                @endif
            </div>
        @endif

        @include('livewire._partials.messages.error')

        @if(count($items))
            @include('livewire.team.permissions._partials.data')
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
