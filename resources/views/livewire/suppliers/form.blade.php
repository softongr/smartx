<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    @if($id)
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Accessibility</i>
                        {{ __('Edit Supplier') }}
                        <span class="  whitespace-nowrap inline-block py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                            {{$name}}
                        </span>

                    @else
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">add</i>
                        {{ __('Add new supplier') }}
                    @endif
                </div>
            </h4>
        </div>

            @include('livewire._partials.back-to-list',['url'=> route('suppliers.index')])

    </div>

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">

                @include('livewire._partials.messages.success')
                @include('livewire._partials.messages.error')

                <form wire:submit.prevent="save" class="mt-5">
                    <div class="grid lg:grid-cols-3 gap-6 ">
                        <div>
                            <x-input-label for="name" :value="__('Name')" required="true"></x-input-label>
                            <x-text-input wire:model="name" id="name" placeholder="{{__('Name')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('name')" />
                        </div><!-- div-->



                        <div>
                            <x-input-label for="email" :value="__('Email')"></x-input-label>
                            <x-text-input wire:model="email" id="email" placeholder="{{__('Email')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('email')" />
                        </div><!-- div-->

                        <div>
                            <x-input-label for="website" :value="__('Website')"></x-input-label>
                            <x-text-input wire:model="website" id="website" placeholder="{{__('Website')}}" type="text"
                                          class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('website')" />
                        </div><!-- div-->

                    </div>

                    <div class="grid lg:grid-cols-3 gap-6 mt-5">
                        <div>
                            <x-input-label for="address" :value="__('Address')" required="true"></x-input-label>
                            <x-text-input wire:model="address" id="address" placeholder="{{__('Address')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('address')" />
                        </div><!-- div-->



                        <div>
                            <x-input-label for="city" :value="__('City')" required="true"></x-input-label>
                            <x-text-input wire:model="city" id="city" placeholder="{{__('City')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('city')" />
                        </div><!-- div-->

                        <div>
                            <x-input-label for="postcode" :value="__('Postcode')" required="true"></x-input-label>
                            <x-text-input wire:model="postcode" id="postcode" placeholder="{{__('Postcode')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('postcode')" />
                        </div><!-- div-->

                    </div>

                    <div class="grid lg:grid-cols-2 gap-6 mt-5">
                        <div>
                            <x-input-label for="phone" :value="__('Phone')"></x-input-label>
                            <x-text-input wire:model="phone" id="phone" placeholder="{{__('Phone')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('phone')" />
                        </div><!-- div-->

                        <div>
                            <x-input-label for="phone" :value="__('Map Url')"  required="true"></x-input-label>
                            <x-text-input wire:model="map_url" id="map_url" placeholder="{{__('Map url')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('map_url')" />
                        </div><!-- div-->
                    </div>
                    <div class="grid lg:grid-cols-3 gap-6 mt-5">
                        <div>

                            <div class="flex flex-col gap-3">
                                <h6 class="text-sm mb-2"> {{ __('API') }}</h6>
                                <div class="flex items-center">
                                    <input wire:change="toggleApi" class="form-switch" type="checkbox" role="switch"
                                           id="API" wire:model="api" @if($api) checked="true" @endif>
                                    <label class="ms-1.5" for="API"> {{ __('Yes') }}</label>
                                </div>
                            </div>
                        </div>

                        @if($api)
                            <div>
                                <x-input-label for="api_type" :value="__('API Type')" required="true"></x-input-label>
                                <select wire:change="apiType($event.target.value)"
                                        class="form-select"  wire:model="api_type">
                                    <option value="0"> {{ __('Select') }}</option>
                                    <option value="xml">{{ __('XML') }}</option>
                                    <option value="json">{{ __('JSON') }}</option>

                                </select>

                                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('api_type')" />

                            </div>
                        @endif

                        @if($show_api_url || !empty($api_type && $api))
                            <div>
                                <x-input-label for="api_url" :value="__('API URL')" required="true"></x-input-label>
                                <x-text-input wire:model="api_url" id="api_url" placeholder="{{__('API URL')}}"
                                              type="text" class="mt-1 block w-full" />
                                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('api_url')" />
                            </div><!-- div-->
                        @endif

                    </div>

                    <div class="grid lg:grid-cols-1 gap-6 mt-5">
                        <div class="flex  justify-start items-center gap-2">
                            @include('livewire._partials.save',['id'=> $id])

                                @include('livewire._partials.back-to-list',['url'=> route('suppliers.index')])

                        </div><!-- flex  justify-start items-center gap-2-->
                    </div><!-- grid lg:grid-cols-1 gap-6 mt-5-->
                </form><!-- form-->


            </div>
        </div>
    </div>
</div>
