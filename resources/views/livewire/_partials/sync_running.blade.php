@if (is_sync_running())
    <div wire:poll.500ms>
        <div class="border border-yellow-600/20 bg-yellow-600/10 text-sm text-yellow-600 rounded-md px-4 py-3 w-full mb-5">
            <span class="font-bold">{{ __('Warning') }}</span>
            {{ __('The store is currently syncing. Please be patient. Thank you!') }}
        </div><!-- border border-yellow-600/20 bg-yellow-600/10 text-sm text-yellow-600 rounded-md px-4 py-3 w-full mb-5 -->
    </div>
@endif
