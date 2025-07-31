
        <form wire:submit.prevent="save" class="mt-5">
            <div class="grid lg:grid-cols-3 gap-6 ">

                <div>
                    <x-input-label for="openai_api_key" :value="__('API Key')" required="true"></x-input-label>
                    <x-text-input wire:model="openai_api_key" id="openai_api_key" placeholder="{{__('API Key')}}"
                                  type="text" class="mt-1 block w-full" />
                    <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('openai_api_key')" />
                </div>

                <div>
                    <x-input-label for="openai_organization" :value="__('Organization')"></x-input-label>
                    <x-text-input wire:model="openai_organization" id="openai_organization" placeholder="{{__('Organization')}}"
                                  type="text" class="mt-1 block w-full" />
                    <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('openai_organization')" />
                </div>





                <div>
                    <x-input-label for="name" :value="__('OpenAi Model')" required="true"></x-input-label>
                    <select wire:model="openai_model" class="form-select">
                        <option value="">{{ __('Select') }}</option>
                        @foreach($available_models as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('openai_model')" />
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6 mt-5 ">
                <div>
                    <x-input-label for="openai_max_tokens" :value="__('Max tokens')"></x-input-label>
                    <x-text-input wire:model="openai_max_tokens" id="openai_max_tokens" placeholder="{{__('Max tokens')}}"
                                  type="text" class="mt-1 block w-full" />
                    <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('openai_max_tokens')" />
                </div>

                <div>
                    <x-input-label for="openai_temperature" :value="__('Temperature')"></x-input-label>
                    <x-text-input wire:model="openai_temperature" id="openai_temperature" placeholder="{{__('Temperature')}}"
                                  type="text" class="mt-1 block w-full" />
                    <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('openai_temperature')" />
                </div>

                <div>
                    <x-input-label for="openai_default_language" :value="__('Default Language')"></x-input-label>
                    <x-text-input wire:model="openai_default_language" id="openai_default_language" placeholder="{{__('Default Language')}}"
                                  type="text" class="mt-1 block w-full" />
                    <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('openai_default_language')" />
                </div>




                <div class="flex items-center">
                    <input class="form-switch" type="checkbox" role="switch"
                           id="openai_prompt_debug"   wire:model.defer="openai_prompt_debug">




                    <x-input-label class="ms-1.5" for="openai_prompt_debug"
                                   :value="__('Prompt Debug')"></x-input-label>
                </div>



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

