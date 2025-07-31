<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    @if($id)
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Person</i>
                        {{ __('Edit Role') }}
                        <span class="  whitespace-nowrap inline-block py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                            {{$name}}
                        </span>
                    @else
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">add</i> {{ __('Add new Role') }}
                    @endif
                </div>
            </h4>
        </div> <!-- div -->
        @if($user->isSuperAdmin() || $user->can('permissions.index'))
            <div>
                @include('livewire._partials.back-to-list',['url'=> route('permissions.index')])
            </div><!-- div -->
        @endif
    </div><!-- flex items-center justify-between flex-wrap gap-2 mb-6-->
    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">
                @include('livewire._partials.messages.success')
                <form wire:submit.prevent="save" class="mt-5">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" required="true"></x-input-label>
                            <x-text-input wire:model="name" id="name" placeholder="{{__('Name')}}" type="text" class="mt-1 block w-full" />
                            @error('name')
                                <span class="text-red-500 text-xs font-medium mt-5">{{ $message }}</span>
                            @enderror
                        </div> <!-- div -->
                    </div><!-- grid lg:grid-cols-2 gap-6-->
                    <div class="grid lg:grid-cols-1 gap-6 mt-5">
                        <div class="flex  justify-start items-center gap-2">
                            @include('livewire._partials.save',['id'=> $id])
                            @if($user->isSuperAdmin() || $user->can('permissions.index'))
                                @include('livewire._partials.back-to-list',['url'=> route('permissions.index')])
                            @endif
                        </div><!-- flex  justify-start items-center gap-2-->
                    </div><!-- grid lg:grid-cols-1 gap-6 mt-5-->
                </form><!-- form mt-5-->
            </div><!-- p-6 -->
        </div><!-- card -->
    </div><!-- flex flex-col gap-6-->
</div><!-- div -->
