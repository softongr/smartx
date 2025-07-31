<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Label</i>
                    {{ $role->name }}
                    <span class="whitespace-nowrap inline-block py-1.5 px-3 rounded-md text-xs font-medium
                    bg-green-100 text-green-800">
                        {{ __('Permissions') }}
                    </span>
                </div>
            </h4>
        </div>

        @if($user->isSuperAdmin() || $admin->can('roles.create'))
            <div>
                <div class="flex justify-center items-center gap-3">
                    <a href="{{route('roles.index')}}"
                       class="  btn rounded-full bg-gray-200 flex justify-center items-center">
                        <span>{{ __('Back to List') }}</span>
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Undo</i>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="card overflow-hidden p-6">
        @include('livewire._partials.messages.success')
        @include('livewire._partials.messages.error')
        @if(count($permissions))
            <div class="flex items-center gap-2">
                <div>
                    <input  wire:model="selectAll"   wire:click="toggleSelectAll"
                            class="form-checkbox rounded text-blue" type="checkbox" id="selectAll">
                    <label class="ms-1.5" for="selectAll"> {{ $selectAll ? 'Αποεπιλογή Όλων' : 'Επιλογή Όλων' }}</label>
                </div>
            </div>
        <hr>
        @endif

        @if(count($permissions))
            @include('livewire.team.roles._partials.permissions')
        @else
            @include('livewire._partials.nodata',['url'=>''])
        @endif

    </div><!-- card overflow-hidden p-6-->
</div>
