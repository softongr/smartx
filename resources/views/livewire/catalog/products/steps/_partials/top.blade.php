<div class="card overflow-hidden p-6 mb-10">

    @if($checkCategoryMapper)

        <div class="flex justify-start items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            <strong>{{ __('Some categories have not been mapped.Please complete the mapping in order to proceed.') }}</strong>

            <a class="btn  bg-primary text-white gap-1" href="{{ route('marketplace.map', $marketplace) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>

                {{ __('Check All Categories') }}
            </a>
        </div>

    @else
        <div class="flex justify-between items-center gap-5">
            <div class="flex justify-around items-center gap-5">
                @if($image !=null)
                    <img class="inline-block size-[62px] rounded-lg" src="{{ $image }}" width="50" />
                @endif

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
                    @if($object->mpn || $object->ean)
                        <div class="flex gap-2 items-center">
                            @if($object->mpn)
                                <div class="mpn text-xs">
                                    {{ __('MPN:') }}  <i> {{ $object->mpn }}</i>
                                </div>
                            @endif
                            @if($object->ean)
                                |
                                <div class="mpn text-xs">
                                    {{ __('EAN:') }}  <i> {{ $object->ean }}</i>
                                </div>
                            @endif
                        </div>

                    @endif


                </div>
            </div>

            <div class="flex justify-between items-center gap-5">



            @if (!empty($features))
                <div>
                    <button type="button" class="btn rounded-full  bg-primary text-white gap-3"
                            data-hs-overlay="#overlay-top">
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Assignment</i>
                        <span>{{ __('View Features') }}</span>
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

                @if (!empty($shopPrices))
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
        </div>


    @endif

</div>
