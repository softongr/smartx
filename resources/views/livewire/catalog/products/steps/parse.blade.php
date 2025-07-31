<small class="mb-5 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
    </svg>
    {{ __('Automatic extraction of title, description, images, and calculation of the product price based on predefined rules.') }}

</small>




@if(!check_product_status($id))


<form wire:submit.prevent="save">
    <button type="submit" class="btn btn-lg bg-primary text-white gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
        </svg>

        <span class="ml-2">
                        {{ __('Next step') }}
                    </span><!-- ml-2 -->
    </button><!-- btn rounded-full  bg-primary text-white gap-3-->

</form>
@else
    <div class="flex items-center justify-start gap-3">
        <div class="animate-spin w-4 h-4 border-[3px] border-current border-t-transparent text-amber-500 rounded-full"
             role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
        </div>
        <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-warning text-white rounded me-1">

                                         {{ __('Currently performing operations... Please wait. (We are analyzing the data step by step.)') }}
        </span>
    </div>
@endif

