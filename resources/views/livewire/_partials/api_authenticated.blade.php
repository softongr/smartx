<div class="card overflow-hidden p-6">
    <div class="flex justify-start items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" style="color: black; stroke: black;"
             stroke="currentColor" class="size-10 text-black ">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0
                        5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
        </svg>
        <div>
            <h1 class="text-2xl">
                {{ __('Cannot proceed with synchronization.') }}
            </h1><!-- text-2xl-->
            <small class="text-sm">
                {{ __('Invalid API settings detected. Please check your configuration or contact the developer.') }}
            </small><!-- text-sm-->
        </div><!-- div -->
    </div><!-- flex justify-start items-center gap-2-->
</div><!-- card overflow-hidden p-6-->
