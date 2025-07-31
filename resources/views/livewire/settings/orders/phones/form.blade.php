<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-3 gap-6">

        <div>
            <x-input-label for="cod_fee" :value="__('Cod Fee')" required="true"></x-input-label>
            <x-text-input wire:model="cod_fee" id="cod_fee" placeholder="{{__('Cod Fee')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('cod_fee')" />
        </div><!-- div-->

        <div>
            <x-input-label for="shipping_fee" :value="__('Shipping Fee')" required="true"></x-input-label>
            <x-text-input wire:model="shipping_fee" id="shipping_fee" placeholder="{{__('Shipping Fee')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('shipping_fee')" />
        </div><!-- div-->

        <div>
            <x-input-label for="free_shipping_threshold" :value="__('Free Shipping Threshold')" required="true"></x-input-label>
            <x-text-input wire:model="free_shipping_threshold" id="free_shipping_threshold" placeholder="{{__('Free Shipping Threshold')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('free_shipping_threshold')" />
        </div><!-- div-->
    </div>
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
            <span class="ml-2">
                        {{ __('Save') }}
                    </span><!-- ml-2 -->
        </button><!-- btn rounded-full  bg-primary text-white gap-3-->
    </div>




</form>
