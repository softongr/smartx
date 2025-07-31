<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-3 gap-6">
        <div>
            <x-input-label for="default_quantity" :value="__('Default Quantity')" required="true"></x-input-label>
            <x-text-input wire:model="default_quantity" id="default_quantity" placeholder="{{__('Default Quantity')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('default_quantity')" />
            <div class="mt-2">


                 <small class="flex justify-start items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>

                <i>
                    {{ __('Default stock quantity. If no quantity is entered during product creation, the value you set here will be used automatically.') }}
                </i>
                </small>
            </div>
        </div><!-- div-->

        <div>
            <x-input-label for="income_tax" :value="__('Income Tax')" required="true"></x-input-label>
            <x-text-input wire:model="income_tax" id="income_tax" placeholder="{{__('Income Tax')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('income_tax')" />
            <div class="mt-2">


                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>

                    <i>
                        {{ __('Default stock quantity. If no quantity is entered during product creation, the value you set here will be used automatically.') }}
                    </i>
                </small>
            </div>
        </div><!-- div-->

        <div>
            <x-input-label for="default_minimum_profit" :value="__('Default minimum profit')" required="true"></x-input-label>
            <x-text-input wire:model="default_minimum_profit" id="default_minimum_profit" placeholder="{{__('Default minimum profit')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('default_minimum_profit')" />

            <div class="mt-2">


                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>

                    <i>
                        {{ __('The minimum profit margin that will be applied automatically if not specified differently for the product.') }}
                    </i>
                </small>
            </div>
        </div><!-- div-->

    </div>


    <hr class="mt-5">

    <div class="grid lg:grid-cols-2  mt-5 ">



        <div>


            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="openai_auto_apply_prompts"   wire:model.defer="openai_auto_apply_prompts">

                <x-input-label class="ms-1.5" for="openai_auto_apply_prompts"
                               :value="__('Auto Apply Prompts')"></x-input-label>
                <small></small>
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('If enabled, during product creation the fields Meta Title, Meta Description, Description, and others will be automatically generated using artificial intelligence.') }}
                    </i>
                </small>
            </div>
        </div>

        <div>


            <div class="flex items-center">

                <input class="form-switch" type="checkbox" role="switch"
                       id="scrape_log_enabled"   wire:model.defer="scrape_log_enabled">

                <x-input-label class="ms-1.5" for="scrape_log_enabled"
                               :value="__('scrape_log_enabled')"></x-input-label>
                <small></small>


            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to log scraping actions.') }}
                    </i>
                </small>
            </div>
        </div>

    </div>

    @if(count($markets))
    <hr class="mt-5">
        <div class="grid lg:grid-cols-1  mt-5 ">
            <div>
                <x-input-label for="default_marketplace_for_add_product" :value="__('Default Marketplace for add product')"></x-input-label>
                <select wire:model="default_marketplace_for_add_product"  class="form-select">
                    <option value="0">{{ __('Select') }}</option>
                    @foreach($markets as $marketplace)
                        <option value="{{ $marketplace->id }}">{{ $marketplace->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('default_marketplace_for_add_product')" />
            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Select the marketplace where a new product will be automatically added.') }}
                    </i>
                </small>
            </div>
        </div>
    @endif

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
