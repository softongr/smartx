@if(!$checkCategoryMapper)
<div class="card overflow-hidden p-6 mb-10 mt-5">
    <form wire:submit.prevent="save" class="mt-6">
        <div class="grid lg:grid-cols-4 gap-6 mt-5">
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
                @if($object->safety_price)
                    <i>
                        <small>
                            {{ __('messages.safety_price_message', ['price' => $object->safety_price]) }}

                        </small>
                    </i>

                @endif
            </div><!-- div-->

            @foreach($marketplacesPrices as $price)
                <div>

                    <div class="flex items-center gap-2 justify-between">

                        <!-- Εμφάνιση του ονόματος του Marketplace -->
                        <x-input-label for="prices[{{ $price->id }}][price]" :value="__('Price for ' . $price->name)"></x-input-label>
                        <p class="text-xs md:text-base">
                            <small>
                                {{ __('messages.margin.profit', ['margin' => $price->pivot?->profit_margin]) }}
                            </small>
                        </p>
                    </div>

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

                    <i>
                        <small>

                            {{ __('messages.safety_price_message.with_comissions', ['price' => $price->pivot?->safety_price ?? '']) }}

                        </small>
                    </i>

                    <input type="hidden" name="prices[{{ $price->id }}][profit_margin]" value="{{ $price->pivot?->profit_margin ?? '' }}">

                </div>
            @endforeach


        </div>

        <div class="grid lg:grid-cols-2 gap-6 mt-5">
        <div>
            <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                <span class="ml-2">
                        {{ __('Platform Ready') }}
                    </span><!-- ml-2 -->
            </button><!-- btn rounded-full  bg-primary text-white gap-3-->
        </div>


        </div>

    </form>
</div>
@endif
