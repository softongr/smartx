<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/new/app.css','resources/css/new/icons.css'])
    @livewireStyles

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


</head>
<body>
<div class="flex wrapper">
    @include('layouts.navigation')
    <!-- Start Page Content here -->
    <div class="page-content">
        <!-- Page Heading -->

        <!-- Topbar Start -->
        <header class="sticky top-0 bg-white h-16 flex items-center px-5 gap-4 z-50">
            <!-- Topbar Brand Logo -->



{{--            <a href="/" class="md:hidden flex">--}}
{{--                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="flex h-6">--}}
{{--            </a>--}}






            <!-- Sidenav Menu Toggle Button -->
            <button id="button-toggle-menu" class="text-gray-500 hover:text-gray-600 p-2 rounded-full cursor-pointer"
                    data-hs-overlay="#app-menu" aria-label="Toggle navigation">
                <i class="ti ti-menu-2 text-2xl"></i>
            </button>

            <!-- Language Dropdown Button -->
            <div class="ms-auto hs-dropdown relative inline-flex [--placement:bottom-right]">

            </div>



            <!-- Profile Dropdown Button -->
            <div class="relative">
                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                    <button type="button" class="hs-dropdown-toggle nav-link flex items-center gap-2">

                                <span class="md:flex items-center hidden">
                                <span class="font-semibold text-base">{{ Auth::user()->name }}</span>
                                <i class="ti ti-chevron-down text-sm ms-2"></i>
                            </span>
                    </button>
                    <div
                        class="hs-dropdown-menu duration mt-2 min-w-[12rem] rounded-lg border border-default-200
                                 bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                        <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100"
                           href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </a>



                        <hr class="my-2">


                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                                   onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </header>


        <!-- Page Content -->
        <main class="flex-grow p-6">
            @isset($header)

                {{ $header }}
                -
            @endisset
            {{ $slot }}
        </main>

        <!-- Footer Start -->
        {{--            border-t border-gray-200 shadow--}}
        <footer class="footer h-16 flex items-center px-6 bg-white ">
            <div class="flex md:justify-between justify-center w-full gap-4">
                <div>
                    <script>document.write(new Date().getFullYear())</script> © nextpointer.gr
                </div>
                <div class="md:flex hidden gap-2 item-center md:justify-end">
                    {{__('Development by')}} <a href="https://nextpointer.gr" target="_blank" class="text-primary">nextpointer.gr</a>
                </div>
            </div>
        </footer>
    </div>
</div>


@vite(['resources/js/new/jquery.min.js', 'resources/js/new/preline.js', 'resources/js/new/simplebar.min.js',
'resources/js/new/iconify-icon.min.js', 'resources/js/new/quill.min.js' ,'resources/js/new/form-editor.js',
 'resources/js/app.js'])

@livewireScripts


@stack('scripts')
<!-- Way 1 -->






</body>
</html>
