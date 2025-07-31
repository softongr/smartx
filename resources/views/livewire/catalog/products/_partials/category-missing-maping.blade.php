@if($checkCategoryMapper)

    <div class="flex items-center gap-2 mt-5  mb-5 px-4 py-3 border
     border-yellow-300 bg-yellow-50
     text-yellow-800 rounded-md text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        <span>
            <strong>{{ __('You cannot proceed.The reason is that you must first map the new categories') }}
            </strong>
        </span>

        <a href="{{ route('marketplaces.index') }}"
           class="inline-flex items-center px-3 py-1.5 rounded-md bg-yellow-600 text-white text-sm font-medium hover:bg-yellow-700 transition">
            {{ __('Go marketplaces Page') }}
        </a>
    </div>



@endif
