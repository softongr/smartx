<x-guest-layout>


    <form method="POST" action="{{ route('password.confirm') }}" class="mt-8" autocomplete="off">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="ti ti-fingerprint text-xl"></i>
                </div>
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div >
            <x-primary-button-auth>
                {{ __('Confirm') }}
            </x-primary-button-auth>
        </div>
    </form>
</x-guest-layout>
