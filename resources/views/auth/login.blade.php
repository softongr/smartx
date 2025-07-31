<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8" autocomplete="off">
        @csrf
        <div class="space-y-5">
        <!-- Email Address -->
        <div>
            <x-input-label-auth for="email" :value="__('Email')" />
            <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="ti ti-user text-xl"></i>
                </div>
                <x-text-input-auth id="email"  type="email" name="email" :value="old('email')" required autofocus autocomplete="off" />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <x-input-label-auth for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                 <a href="{{ route('password.request') }}"
                   class="text-sm font-medium text-sky-500 underline"> {{ __('Forgot your password?') }}</a>
                @endif
            </div>

            <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="ti ti-fingerprint text-xl"></i>
                </div>

            <x-text-input-auth id="password"
                            type="password"
                            name="password"
                            required autocomplete="current-password" autocomplete="new-password"/>

            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

{{--        <!-- Remember Me -->--}}
{{--        <div>--}}
{{--            <label for="remember_me" class="inline-flex items-center">--}}
{{--                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">--}}
{{--                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--            </label>--}}
{{--        </div>--}}
            <div>
                <x-primary-button-auth class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button-auth>

            </div>
{{-- <div class="flex justify-center items-center mt-8">
      <p class="mt-2 text-base text-gray-600">
          {{__('Dont have an account ?')}}
          <a href="{{route('register')}}" title=""  class="font-medium text-sky-600 transition-all duration-200
              hover:text-sky-700 focus:text-sky-700 hover:underline">{{ __('Sign up') }}</a>
      </p>
  </div>--}}
</div>
</form>
</x-guest-layout>
