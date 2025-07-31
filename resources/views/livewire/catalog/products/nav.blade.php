<div class="flex justify-between items-center mb-5">


    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
        <li class="me-2">
            <button wire:click="$set('step', '1')"
                    class="inline-flex items-center justify-center p-4 gap-2 border-b-2 rounded-t-lg group
                       {{ $step === '1' ? 'text-blue-600 border-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                </svg>
                {{ __('New Products') }} <span class="ml-1 bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded">{{ $stepCounts['1'] ?? 0 }}</span>
            </button>
        </li>
        <li class="me-2">
            <button wire:click="$set('step', '2')"
                    class="inline-flex items-center justify-center p-4 gap-2 border-b-2 rounded-t-lg group
                       {{ $step === '2' ? 'text-blue-600 border-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                {{ __('Analysis') }} <span class="ml-1 bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded">{{ $stepCounts['2'] ?? 0 }}</span>
            </button>
        </li>

        <li class="me-2">
            <button wire:click="$set('step', '4')"
                    class="inline-flex items-center justify-center p-4 gap-2 border-b-2 rounded-t-lg group
                       {{ $step === '4' ? 'text-blue-600 border-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ __('Pricing') }} <span class="ml-1 bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded">{{ $stepCounts['4'] ?? 0 }}</span>
            </button>
        </li>
    </ul>

    @if($step === '1')
        <button wire:click="exportToJson"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            </svg>
            {{ __('Export JSON') }}
        </button>
    @endif


</div>




<div wire:loading wire:target="step,search"  class="flex justify-between gap-8">
    <strong class="text-default-900">Loading...</strong>

    <div class="animate-spin w-8 h-8 border-[3px] border-current border-t-transparent text-default-900 rounded-full"
         role="status" aria-label="loading">
        <span class="sr-only">Loading...</span>
    </div>
</div>
