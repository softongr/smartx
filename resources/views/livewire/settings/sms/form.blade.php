<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-3 gap-6">
        <div>
            <x-input-label for="sms_store_name" :value="__('Store Name')" required="true"></x-input-label>
            <x-text-input wire:model="sms_store_name" id="sms_store_name" placeholder="{{__('Store Name')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('sms_store_name')" />
        </div><!-- div-->
        <div>
            <x-input-label for="admin_phone_number" :value="__('Admin Phone Number')" required="true"></x-input-label>
            <x-text-input wire:model="admin_phone_number" id="admin_phone_number" placeholder="{{__('Admin Phone Number')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('admin_phone_number')" />
        </div><!-- div-->

        <div>
            <x-input-label for="sms_api_key" :value="__('API Key')"
                           required="true"></x-input-label>
            <x-text-input wire:model="sms_api_key" id="sms_api_key"
                          placeholder="{{__('API Key')}}"
                          type="text" class="mt-1 block w-full"
            />
            <x-input-error class="text-red-500 text-xs font-medium pb-5"
                           :messages="$errors->get('sms_api_key')" />
            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>{{ __('Go to easysms.gr and copy the API key.') }}<code><a href="https://easysms.gr" target="_blank">easysms.gr</a></code></i>
                </small><!-- flex justify-start items-center gap-2-->
            </div><!-- mt-2-->
        </div><!-- div-->
    </div><!-- div -->



    @if(!is_sync_running())
        <div class="grid lg:grid-cols-2 gap-6 mt-5" style="margin-top: 50px;">
            <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3">
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                <span class="ml-2">{{ __('Save') }}</span><!-- ml-2 -->
            </button><!-- btn rounded-full  bg-primary text-white gap-3-->

            @if(!empty($sms_api_key))
                <div class="grid lg:grid-cols-2 gap-5">
                    <div>
                        <x-text-input wire:model="test_phone_number" id="test_phone_number"
                                      placeholder="{{__('Phone')}}"
                                      type="text" class=" block w-full"
                                      style="height: 100%"
                        />
                        <x-input-error class="text-red-500 text-xs font-medium"
                                       :messages="$errors->get('test_phone_number')"/>
                    </div> <!-- div -->
                    <div>
                        <button style="height: 100%;width: 100%"
                                wire:click="testSms" type="button"
                                class="btn  bg-primary/25 text-primary hover:bg-primary hover:text-white">
                            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Send</i>
                            <span class="ml-1">{{ __('Send Test SMS') }}</span>
                        </button>
                    </div> <!-- div -->
                </div><!-- grid lg:grid-cols-2 gap-5-->
            @endif
        </div><!-- grid lg:grid-cols-2 gap-6 mt-5 -->
    @else
        <div wire:poll.500ms class="mt-5">
            @include('livewire._partials.sync_running')

        </div>
    @endif


</form> <!-- form -->





