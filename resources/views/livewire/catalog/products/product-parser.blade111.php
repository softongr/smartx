
<div>
    @if($step === \App\ProductStep::Pricing || $step !=  \App\ProductStep::Scrape)
    <div class="card overflow-hidden p-6 mb-10">
    <div class="flex items-center justify-between flex-wrap gap-2">

        @if($step === \App\ProductStep::Pricing || $step ===  \App\ProductStep::OpenAI)
            <div>
                <h4 class="text-slate-900 text-lg font-medium mb-2">
                    <div class="flex justify-around items-center gap-5">
                        <img class="inline-block size-[62px] rounded-lg" src="{{ $image }}" width="50" />
                         <div class="flex justify-start flex-col gap-1">

                            <div class="text-xs flex gap-1 justify-start items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>

                                <i>   {{ __('Last Scraped:') }}  {{$last_scraped_at}}</i>

                            </div>
                            <div class="name ">
                                <a target="_blank" href="{{$object->scrape_link}}">
                                <h1 class="flex gap-2 flex gap-1 justify-start items-center">


                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                    {{ $object->name }}


                                </h1>
                                </a>
                            </div>
                             @if($object->mpn)
                                 <div class="mpn text-xs">
                                    {{ __('MPN:') }}  <i> {{ $object->mpn }}</i>
                                 </div>

                             @endif

                         </div>



                    </div> <!-- flex justify-start items-center gap-2-->
                </h4><!-- text-slate-900 text-lg font-medium mb-2-->



            </div><!-- DIV -->
        @endif

            @if($features)
                <div>


                    <button type="button" class="btn rounded-full  bg-primary text-white gap-3"
                            data-hs-overlay="#overlay-top">
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Assignment</i>
                        <span>
                     {{ __('View Features') }}
                </span>

                    </button>

                    <div id="overlay-top"
                         class="hs-overlay hs-overlay-open:translate-y-0
                 -translate-y-full fixed top-0 inset-x-0 transition-all duration-300 transform  h-full w-full z-[80] bg-white border-b border-default-200 hidden">
                        <div
                            class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                            <h3 class="text-xl font-medium text-default-600">
                                {{__('Product Features')}}
                            </h3>
                            <button type="button" class="hover:text-default-900"
                                    data-hs-overlay="#overlay-top">
                                <span class="sr-only">{{ __('Close') }}</span>
                                <i class="ti ti-x text-lg"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-3 ">


                                @foreach($features as $feature)
                                    <div class="col-xl-3 col-md-6">
                                        <strong> {{$feature['name']}}: </strong>   {{$feature['value']}}
                                    </div>



                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @if($step !=  \App\ProductStep::Scrape)






                <button wire:click="resetWizard"
                        class="btn bg-danger text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                    </svg>

                    {{ __('Reset Wizard') }}
                </button>
            @endif




    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->

    </div>
    @endif

    <div class="card overflow-hidden p-6 mt-5">


        @include('livewire._partials.messages.success')
        @include('livewire._partials.messages.error')
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">


            <div class="border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                    <li class="me-2">
                        <a
                           class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                   {{ $step === \App\ProductStep::Scrape
                       ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                       : 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                            </svg>

                            {{ __('Scraping') }}
                        </a>
                    </li>

                    <li class="me-2">
                        <a
                           class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                   {{ $step === \App\ProductStep::Parse
                       ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                       : 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        {{ __('Analysis') }}

                        </a>
                    </li>




                    <li class="me-2">
                        <a
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                   {{ $step === \App\ProductStep::OpenAI
                       ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                       : 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>


                            {{ __('Details') }}
                        </a>
                    </li>


                    <li class="me-2">
                        <a
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                   {{ $step === \App\ProductStep::Pricing
                       ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                       : 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            {{ __('Pricing') }}
                        </a>
                    </li>

                    <li class="me-2">
                        <a
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                   {{ $step === \App\ProductStep::Shop
                       ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                       : 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>


                            {{ __('Ready for Shop') }}
                        </a>
                    </li>


                </ul>
            </div>




            @if($shopPrices)


                <div>
                    <button type="button" class="btn rounded-full  bg-primary text-white gap-3"
                            data-hs-overlay="#overlay-bottom">
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Store</i>
                        <span>
                     {{ __('Stores') }}
                </span>

                    </button>


                    <div id="overlay-bottom"
                         class="hs-overlay hs-overlay-open:translate-y-0 translate-y-full fixed bottom-0 inset-x-0 transition-all
             duration-300 transform  h-full w-full z-[80] bg-white border-t border-default-200 hidden"
                         tabindex="-1">
                        <div
                            class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                            <h3 class="text-lg font-medium text-default-600">
                                {{ __('Marketplaces Stores') }}
                            </h3>
                            <button type="button" class="hover:text-default-900"
                                    data-hs-overlay="#overlay-bottom">
                                <span class="sr-only">Close modal</span>
                                <i class="ti ti-x text-lg"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <table class="w-full table-auto border">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1">
                                        {{ __('Marketplace') }}
                                    </th>
                                    <th class="border px-2 py-1">
                                        {{ __('Store') }}
                                    </th>
                                    <th class="border px-2 py-1">
                                        {{ __('Price') }}
                                    </th>
                                    <th class="border px-2 py-1">
                                        {{ __('Link') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shopPrices as $shop)
                                    <tr>
                                        <td class="border px-2 py-1">{{ $shop['marketplace'] }}</td>
                                        <td class="border px-2 py-1">{{ $shop['shop'] }}</td>
                                        <td class="border px-2 py-1">{{ number_format($shop['price'], 2) }}€</td>
                                        <td class="border px-2 py-1">
                                            <a href="{{ $shop['url'] }}" class="text-blue-500" target="_blank">link</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif




        </div>



        @if($step === \App\ProductStep::Scrape)
            @include('livewire.catalog.products.steps.scrape')
        @endif

        @if($step === \App\ProductStep::Parse)
            @include('livewire.catalog.products.steps.parse')
        @endif

        @if($step === \App\ProductStep::Pricing)
            @include('livewire.catalog.products.steps.pricing')
        @endif

        @if($step === \App\ProductStep::OpenAI)
            @include('livewire.catalog.products.steps.details')
        @endif

        @if($step === \App\ProductStep::Shop)
            @include('livewire.catalog.products.steps.shop')
        @endif

    </div><!-- card overflow-hidden p-6-->


    <div
        wire:loading
        wire:target="saveDOMHTMLtoDatabase,save,savePrices,saveDetails"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white/70 backdrop-blur-sm"
        @if($forceLoading && $step === \App\ProductStep::Parse)
            style="display: flex;"
        @endif
    >
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <span class="mt-4 text-gray-700 text-sm font-medium">
                @if($step === \App\ProductStep::Scrape)
                   {{ __('Scraping Starting') }}
                @endif

                @if($step === \App\ProductStep::Parse)
                   {{ __('Parsing Starting') }}
                @endif

                @if($step === \App\ProductStep::Pricing)
                 {{ __('Prices starting') }}
                @endif

                    @if($step === \App\ProductStep::OpenAI)
                        {{ __('OpenAI starting') }}
                    @endif

            </span>
        </div>
    </div>


</div>
