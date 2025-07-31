<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-2 gap-5 mt-5">
        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_on_product_sync"
                       wire:model.defer="notify_on_product_sync">

                <x-input-label style="margin-bottom: 0px !important;" class="ms-1.5"
                               for="notify_on_product_sync"
                               :value="__('Email notification on product synchronization')">

                </x-input-label>
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to receive an email each time products are synchronized') }}
                    </i>
                </small>
            </div>
            <hr class="mt-3 mb-3">

        </div>

        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_on_category_sync"   wire:model.defer="notify_on_category_sync">
                <x-input-label  style="margin-bottom: 0px !important;"
                                class="ms-1.5" for="notify_on_category_sync"
                               :value="__('Email notification on category synchronization')">
                </x-input-label>
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to receive an email each time categories are synchronized') }}
                    </i>
                </small>
            </div>
            <hr class="mt-3 mb-3">
        </div>

        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_on_order_sync"   wire:model.defer="notify_on_order_sync">
                <x-input-label style="margin-bottom: 0px !important;"
                               class="ms-1.5" for="notify_on_order_sync"
                               :value="__('Email notification on order synchronization')">
                </x-input-label>
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to receive an email each time orders are synchronized') }}
                    </i>
                </small>
            </div>
            <hr class="mt-3 mb-3">
        </div>

        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_on_carrier_sync"   wire:model.defer="notify_on_carrier_sync">
                <x-input-label style="margin-bottom: 0px !important;"
                               class="ms-1.5" for="notify_on_carrier_sync"
                               :value="__('Email notification on carrier synchronization')">
                </x-input-label>
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to receive an email each time carrier are synchronized') }}
                    </i>
                </small>
            </div>
            <hr class="mt-3 mb-3">
        </div>
    </div>

    <div class="grid lg:grid-cols-1 mt-5">

        <div class="flex items-center">
            <input class="form-switch" type="checkbox" role="switch"
                   id="sync_log_enabled"   wire:model.defer="sync_log_enabled">
            <x-input-label  style="margin-bottom: 0px !important;"
                            class="ms-1.5" for="sync_log_enabled"
                            :value="__('Save Sync Logs')">
            </x-input-label>
        </div>
        <div class="mt-2">
            <small class="flex justify-start items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <i>
                    {{ __('Enable this option to save the sync log files, so you can review them or use them for diagnostic purposes.') }}
                </i>
            </small>
        </div>
        <hr class="mt-3 mb-3">
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mt-5">
        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_syn_custom_email" wire:click="toggleCustomMail"
                       wire:model.defer="notify_syn_custom_email">
                <x-input-label style="margin-bottom: 0px !important;"  class="ms-1.5" for="notify_syn_custom_email"
                    :value="__('Different email for notifications')"></x-input-label>
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Use the system email or specify a different email to receive notifications.') }}
                    </i>
                </small>
            </div>
        </div>

        @if($notify_syn_custom_email)
            <div>
                <x-input-label for="notify_sync_email" :value="__('Email Address')" required="true"></x-input-label>
                <x-text-input wire:model="notify_sync_email" id="notify_sync_email" placeholder="{{__('Email Address')}}"
                              type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('notify_sync_email')" />
            </div><!-- div-->
        @endif
    </div>
    <hr class="mt-5">
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <div>
            <x-input-label for="shop_link" :value="__('Shop Link')" required="true"></x-input-label>
            <x-text-input wire:model="shop_link" id="shop_link" placeholder="{{__('Shop Link')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('shop_link')" />
        </div><!-- div-->

        <div>
            <x-input-label for="shop_api_key" :value="__('Shop API Key')" required="true"></x-input-label>
            <x-text-input wire:model="shop_api_key" id="shop_api_key" placeholder="{{__('Shop API Key')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('shop_api_key')" />
        </div><!-- div-->

        <div class="mb-4">
            <label for="shop_platform" class="form-label font-medium">Πλατφόρμα Καταστήματος</label>
            <select wire:model.defer="shop_platform" id="shop_platform" class="form-select">
                <option value="prestashop">PrestaShop</option>
                <option value="woocommerce">WooCommerce</option>
                <option value="opencart">OpenCart</option>
                <option value="magento">Magento</option>
                <option value="cscart">CSCart</option>
                <option value="custom">Custom API</option>
            </select>
        </div>
    </div>

    <hr class="mt-5">
    <div class="grid lg:grid-cols-2 gap-6 mt-5">
        <div>
            <x-input-label for="sync_per_page" :value="__('Items Per Page for Sync')" required="true" />
            <x-text-input wire:model="sync_per_page" id="sync_per_page" placeholder="{{ __('Items Per Page') }}"
                          type="number" min="1" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('sync_per_page')" />
        </div><!-- div-->
    </div>



    @if(!is_sync_running())
        <div class="grid lg:grid-cols-3 gap-6 mt-5">
            <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                <span class="ml-2">
                            {{ __('Save') }}
                        </span><!-- ml-2 -->
            </button><!-- btn rounded-full  bg-primary text-white gap-3-->
        </div>
    @else
        <div wire:poll.500ms class="mt-5">
            @include('livewire._partials.sync_running')

        </div>
    @endif
</form>



