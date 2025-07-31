
<form wire:submit.prevent="save" class="mt-5">

    <div>
        <x-input-label for="marketplace_id" :value="__('Type')" required="true"></x-input-label>
        <select wire:model="marketplace_id"  class="form-select">
            <option value="0">{{ __('Select') }}</option>
            @foreach($marketplaces as $marketplace)
                <option value="{{ $marketplace->id }}">{{ $marketplace->name }}</option>
            @endforeach
        </select>
        <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('marketplace_id')" />
    </div><!-- div-->

    <div class="grid lg:grid-cols-3 gap-6 mt-5">
            <div>
                <x-input-label for="scrape_link" :value="__('Link Scrape')" required="true"></x-input-label>
                <x-text-input wire:model.defer="scrape_link" id="scrape_link" placeholder="{{__('Link Scrape')}}" type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('scrape_link')" />
            </div><!-- div-->

            <div>
                <x-input-label for="EAN" :value="__('EAN')"></x-input-label>
                <x-text-input wire:model.defer="ean" id="quantity" placeholder="{{__('EAN')}}" type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('ean')" />
            </div><!-- div-->

            <div>
                <x-input-label for="wholesale_price" :value="__('Wholesale Price')" required="true"></x-input-label>
                <x-text-input wire:model.defer="wholesale_price" id="quantity" placeholder="{{__('Wholesale Price')}}" type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('wholesale_price')" />
            </div><!-- div-->

            <div>
                <x-input-label for="Quantity" :value="__('Quantity')" required="true"></x-input-label>
                <x-text-input wire:model.defer="quantity" id="quantity" placeholder="{{__('Quantity')}}" type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('quantity')" />
            </div><!-- div-->


            @if($availableRates)
                    <div class="mb-4 w-full">
                            <label for="rate_vat_id" class="block text-sm font-medium text-gray-700 mb-1" required="true">
                                {{ __('Φ.Π.Α.') }}
                            </label>
                        <select wire:model="rate_vat_id"  class="form-select mt-1">

                                       @foreach($availableRates as $rate)
                                    <option value="{{ $rate['id'] }}" @if($rate_vat_id == $rate['id']) selected @endif>
                                        {{ $rate['name'] }} ({{ number_format($rate['rate'], 2) }}%)
                                        @if($rate['default']) - {{ __('Προεπιλογή') }} @endif
                                    </option>
                                @endforeach
                            </select>
                    </div>
            @else
                        <span class="inline-flex items-center gap-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ __('Unable to proceed – no taxes have been recorded. Please enter the taxes to continue.') }}
                        </span>
            @endif
    </div>

    @if(!is_sync_running())
        <div class="grid lg:grid-cols-2 gap-6 mt-5">
            <div class="w-full flex gap-5">
                @if(!$this->disableSaveButton)
                    <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                        <span class="ml-2">

                                @if($isEdit)
                                {{ __('Edit') }}
                            @else
                                {{ __('Save') }}
                                @endif

                                </span><!-- ml-2 -->
                    </button>
                @else
                    <span class="inline-flex items-center gap-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-red-100 text-red-800">
                     {{ __('Settings for income tax or minimum profit are not configured correctly.') }}
                    </span>
                @endif
            </div><!-- grid lg:grid-cols-1 gap-6 mt-5-->
        </div>
    @endif
</form>



