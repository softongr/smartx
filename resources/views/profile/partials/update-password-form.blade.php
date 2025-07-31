<section>
    <header class="mb-5">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>


    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        <div class="grid lg:grid-cols-1 gap-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>


        </div>

            @if (session('status') === 'password-updated')



                <div class="mb-5">


                    <div   x-data="{ show: true }"
                           x-init="setTimeout(() => show = false, 1000)"
                           x-show="show" id="dismiss-alert" class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-teal-50 border border-teal-200 rounded-md p-4" role="alert">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <i class="ti ti-circle-check text-xl"></i>
                            </div>
                            <div class="flex-grow">
                                <div class="text-sm text-teal-800 font-medium">
                                    {{ __('Saved.') }}
                                </div>
                            </div>
                            <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test" class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                <i class="ti ti-x text-xl"></i>
                            </button>
                        </div>
                    </div>


                </div>
            @endif

        </div>
    </form>
</section>
