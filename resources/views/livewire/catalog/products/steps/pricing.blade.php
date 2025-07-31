



<div class="grid xl:grid-cols-2 md:grid-cols-2 gap-6 mt-6 mb-6">
    @if($price_box)
        <div class="col-xl-3 col-md-6">
            <div class="card bg-purple-100">
                <div class="p-5">
                    <span class="material-symbols-rounded float-end text-3xl text-default-400">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <h6 class="text-muted text-sm uppercase">{{ __('Price Box') }}</h6>
                    <h3 class="text-2xl" data-plugin="counterup"> {{ $price_box }}</h3>
                </div>
            </div>
        </div>
    @endif

    @if($object->average_rating)
        <div class="col-xl-3 col-md-6">
            <div class="card bg-yellow-100">
                <div class="p-5">
                    <span class="material-symbols-rounded float-end text-3xl text-default-400">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-10">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <h6 class="text-muted text-sm uppercase">{{ __('Cheapest store') }}</h6>
                    <h3 class="text-2xl " > {{ $minShop['shop_price'] }}</h3>

                   <strong> {{ $minShop['shop_name'] }}</strong>

                </div>
            </div>
        </div>
    @endif
</div>



<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mt-6 mb-6">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger">
            <div class="p-5">
                <span class="material-symbols-rounded float-end text-3xl text-default-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5"

                         stroke="currentColor"
                         class="size-10 text-white">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332
  9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
</svg>

</span>
                <h6 class="text-white text-sm uppercase">{{ __('Safety Price') }}</h6>
                <h3 class="text-2xl text-white " data-plugin="counterup">  {{$object->safety_price}}</h3>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-gray-100">
            <div class="p-5">
                <span class="material-symbols-rounded float-end text-3xl text-default-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="size-10">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
</svg>

                </span>
                <h6 class="text-muted text-sm uppercase">{{ __('Total Orders') }}</h6>
                <h3 class="text-2xl" data-plugin="counterup"> {{ $object->average_orders }}</h3>

            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-gray-100">
            <div class="p-5">
                <span class="material-symbols-rounded float-end text-3xl text-default-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="size-10">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
</svg>

                </span>
                <h6 class="text-muted text-sm uppercase">{{ __('Total Rating') }}</h6>
                <h3 class="text-2xl " data-plugin="counterup"> {{ $object->average_rating }}</h3>

            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6">
        <div class="card bg-gray-100">
            <div class="p-5">
                <span class="material-symbols-rounded float-end text-3xl text-default-400"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-10">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
</svg>
</span>
                <h6 class="text-muted text-sm uppercase">{{ __('Total Reviews') }}</h6>
                <h3 class="text-2xl " data-plugin="counterup"> {{ $object->average_reviews }}</h3>

            </div>
        </div>
    </div>



    <div class="col-xl-3 col-md-6">
        <div class="card bg-gray-100">
            <div class="p-5">
                <span class="material-symbols-rounded float-end text-3xl text-default-400"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
</svg>
</span>
                <h6 class="text-muted text-sm uppercase">{{ __('Total Shops') }}</h6>
                <h3 class="text-2xl " data-plugin="counterup"> {{ count($shopPrices)  }}</h3>

            </div>
        </div>
    </div>







</div>




<hr>









<form wire:submit.prevent="savePrices" class="mt-6">

    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <div>
            <x-input-label for="wholesale_price" :value="__('Price wholesale')"></x-input-label>
            <x-text-input wire:model="wholesale_price" id="wholesale_price" style="opacity: 0.8"
                          placeholder="{{__('Price wholesale')}}" type="text" class="mt-1 block w-full" readonly />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('wholesale_price')" />

        </div><!-- div-->

        <div>
            <x-input-label for="price" :value="__('Price')" required="true"></x-input-label>
            <x-text-input wire:model="price" id="price" placeholder="{{__('Price')}}" type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('price')" />


        </div><!-- div-->


        @foreach($marketplacesPrices as $price)
            <div>
                <!-- Εμφάνιση του ονόματος του Marketplace -->
                <x-input-label for="prices[{{ $price->id }}][price]" :value="__('Price for ' . $price->name)"></x-input-label>

                <!-- Εμφάνιση της τιμής για το marketplace -->

                <x-text-input
                    wire:model="prices.{{ $price->id }}.price"
                    id="prices[{{ $price->id }}][price]"
                    placeholder="{{ __('Price for ' . $price->name) }}"
                    type="text"
                    value="{{ $price->pivot?->price ?? '' }}"
                    class="mt-1 block w-full"
                />

                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('prices.' . $price->id . '.price')" />

                <p class="text-xs md:text-base mt-2">
                    {{ $price->pivot?->profit_margin ?? '—' }}
                </p>

                <input type="hidden" name="prices[{{ $price->id }}][profit_margin]" value="{{ $price->pivot->profit_margin }}">
            </div>
        @endforeach


        <div>


        <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
            <span class="ml-2">
                        {{ __('Save') }}
                    </span><!-- ml-2 -->
        </button><!-- btn rounded-full  bg-primary text-white gap-3-->
        </div>
    </div>






</form>






