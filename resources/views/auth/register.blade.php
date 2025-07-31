<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="mt-8">
        @csrf
        <div  class="space-y-5">
            <!-- Name -->
            <div>
                <x-input-label-auth for="name" :value="__('Name')" />
                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ti ti-user text-xl"></i>
                    </div>
                    <x-text-input-auth id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label-auth for="email" :value="__('Email')" />
                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ti ti-at text-xl"></i>
                    </div>
                    <x-text-input-auth id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label-auth for="password" :value="__('Password')" />
                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ti ti-fingerprint text-xl"></i>
                    </div>
                    <x-text-input-auth id="password" class="block mt-1 w-full"
                                       type="password"
                                       name="password"
                                       required autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label-auth for="password_confirmation" :value="__('Confirm Password')" />
                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ti ti-fingerprint text-xl"></i>
                    </div>
                    <x-text-input-auth id="password_confirmation" class="block mt-1 w-full"
                                       type="password"
                                       name="password_confirmation" required autocomplete="new-password" />

                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div>
                <x-primary-button-auth>
                    {{ __('Register') }}
                </x-primary-button-auth>
            </div>


            <div class="flex justify-center items-center mt-8">
                <p class="mt-2 text-base text-gray-600">

                    <a href="{{route('login')}}" title=""  class="font-medium text-sky-600 transition-all duration-200
                        hover:text-sky-700 focus:text-sky-700 hover:underline">  {{ __('Already registered?') }}</a>
                </p>
            </div>




        </div>
    </form>

</x-guest-layout>
