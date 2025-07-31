<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tabler Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/front/css/tailwind.css'])
    @vite(['resources/css/front/css/custom.css'])
</head>
<body>


<section class="bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="flex items-center justify-center px-4 py-7 bg-white sm:px-6 lg:px-8 sm:py-16 lg:py-24">
            <div class="xl:w-full xl:max-w-sm 2xl:max-w-md xl:mx-auto">








                {{ $slot }}




            </div>
        </div>

        <div
            class="relative flex items-end px-4 pb-10 pt-60 sm:pb-16 md:justify-center
            lg:pb-24 bg-cover bg-center sm:px-6 lg:h-screen lg:px-8" style="background: #2d2c42;">

            <div class="relative">
                <div class="w-full max-w-xl xl:w-full xl:mx-auto xl: pe-24 xl:max-w-xl">
                    <a href="{{route('login')}}">
                        <img  src="{{ asset('images/my.png') }}" alt="Logo">

                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



</body>

@vite(['resources/css/front/js/preline.js'])

</html>
