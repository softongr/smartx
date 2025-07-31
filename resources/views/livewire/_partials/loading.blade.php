<div
    wire:loading
    wire:target="{{ $events }}"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white/70 backdrop-blur-sm">
    <div class="flex flex-col items-center">
        <svg class="animate-spin h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <span class="mt-4 text-gray-700 text-sm font-medium">
            {{ $text }}
        </span><!-- mt-4 text-gray-700 text-sm font-medium -->
    </div><!-- flex flex-col items-center--->
</div><!-- fixed inset-0 z-50 flex items-center justify-center bg-white/70 backdrop-blur-sm-->
