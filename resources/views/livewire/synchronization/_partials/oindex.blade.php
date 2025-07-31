<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>

                    {{ __('Synchronization') }}
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->



    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->

    <div wire:poll.2000ms>

        @include('livewire._partials.messages.success')
        @include('livewire._partials.messages.error')

            @if(is_api_authenticated())




            <div class="mx-auto w-[1000px]">


            <div class="bg-white rounded-lg  p-4 mb-4">
                <div class="flex justify-between items-center">
                    <div class="text-lg font-semibold">

                        <div class="flex items-center justify-start gap-5">
                            @if($categoryBatch  && $categoryBatch->status === 'running')
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="animate-spin w-8 h-8 border-[3px] border-current border-t-transparent text-default-600 rounded-full"
                                         role="status" aria-label="loading">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                            @endif
                            <div class="flex items-center gap-2 justify-center">
                                @if(!$categoryBatch || optional($categoryBatch)->status !== 'running')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                @endif

                                {{ __('Categories') }}

                            </div>
                        </div>





                     </div>




                    @if(!$categoryBatch || optional($categoryBatch)->status !== 'running')
                        <button class="btn rounded-full bg-dark/25 text-slate-900 hover:bg-dark
                        hover:text-white" wire:click="startCategorySync">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>

                        </button>
                    @endif
                </div>
                @if($categoryBatch  && $categoryBatch->status === 'running')
                    <x-sync-progress
                        :batch="$categoryBatch"
                        :progress="$this->categoryProgress"
                        entity="{{__('Categories')}}"
                    />
                @endif
            </div>


                <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-xl-3 col-md-6">
                            <div class="card">


                            </div>

                        </div>
                </div>



                <div class="bg-white rounded-lg  p-4 mb-4">
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-semibold">

                            <div class="flex items-center justify-start gap-5">
                                @if($categoryBatch  && $categoryBatch->status === 'running')
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="animate-spin w-8 h-8 border-[3px] border-current border-t-transparent text-default-600 rounded-full"
                                             role="status" aria-label="loading">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>

                                @endif
                                <div class="flex items-center gap-2 justify-center">
                                    @if(!$categoryBatch || optional($categoryBatch)->status !== 'running')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                        </svg>
                                    @endif

                                    {{ __('Products') }}

                                </div>
                            </div>





                        </div>




                        @if(!$categoryBatch || optional($categoryBatch)->status !== 'running')
                            <button class="btn rounded-full bg-dark/25 text-slate-900 hover:bg-dark
                        hover:text-white" wire:click="startCategorySync">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>

                            </button>
                        @endif
                    </div>
                    @if($categoryBatch  && $categoryBatch->status === 'running')
                        <x-sync-progress
                            :batch="$categoryBatch"
                            :progress="$this->categoryProgress"
                            entity="{{__('Categories')}}"
                        />
                    @endif
                </div>

</div>

        @else
            <div class="card overflow-hidden p-6">
                <div class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" style="color: black; stroke: black;"
                         stroke="currentColor" class="size-10 text-black ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0
                        5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                    </svg>
                    <div>
                        <h1 class="text-2xl"> {{ __('Cannot proceed with synchronization.') }}</h1>
                        <small class="text-sm">
                            {{ __('Invalid API settings detected. Please check your configuration or contact the developer.') }}
                        </small>
                    </div>
                </div>
            </div>
            @endif

    </div>


    @include('livewire._partials.loading' , ['text' => __('Process'), 'events' => 'startCategorySync'])
</div>








