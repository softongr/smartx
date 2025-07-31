<form wire:submit.prevent="save" class="mt-5">
    <div class="col-span-3">
        <div class="space-y-2">
            <div class="flex flex-col gap-3">
                @foreach($permissions as $permission)
                    <div class="flex items-center gap-2">
                        <input
                            wire:model="selectedPermissions" class="form-switch"
                            role="switch"
                            type="checkbox"
                            value="{{ $permission->name }}"
                            id="permission_{{ $permission->id }}"
                            class="form-check-input"
                        >

                        <label for="permission_{{ $permission->id }}" class="ms-1.5">
                            {{ ucfirst($permission->name) }}
                        </label> <!-- ms-1.5-->
                    </div><!-- flex items-center gap-2-->
                @endforeach
            </div><!-- flex flex-col gap-3-->
        </div><!-- space-y-2-->

        @error('selectedPermissions')
                <span class="text-red-500 text-xs font-medium mt-5">
                    {{ $message }}
                </span><!-- text-red-500 text-xs font-medium mt-5-->
        @enderror
    </div><!-- col-span-3-->

    <div class="flex mt-5 justify-start items-center gap-2">
        <div class="flex justify-start items-center gap-2">
            <button type="submit" class="btn rounded-full bg-primary text-white gap-3">
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                <span class="ml-2">{{ __('Save') }}</span>
            </button><!--- btn rounded-full bg-primary text-white gap-3 -->
            <a href="{{ route('roles.index') }}"
               class="btn rounded-full bg-gray-200 flex justify-center items-center">
                <span>{{ __('Back to List') }}</span>
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Undo</i>
            </a><!-- btn rounded-full bg-gray-200 flex justify-center items-center-->
        </div><!-- flex justify-start items-center gap-2-->
    </div><!-- flex mt-5 justify-start items-center gap-2-->
</form><!-- form -->
