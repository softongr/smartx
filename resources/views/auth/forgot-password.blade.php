<x-guest-layout>


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-8" autocomplete="off">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label-auth for="email" :value="__('Email')" />
            <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="ti ti-user text-xl"></i>
                </div>
            <x-text-input-auth id="email"  type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-3">
            <x-primary-button-auth class="ms-3">
                {{ __('Email Password Reset Link') }}
            </x-primary-button-auth>
        </div>
    </form>
</x-guest-layout>
