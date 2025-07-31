<div  wire:poll.500ms>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    @if($id)
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Reminder</i>
                        {{ __('Edit Prompt') }}
                        <span class="  whitespace-nowrap inline-block py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                            {{$name}}
                        </span>

                    @else
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">add</i>
                        {{ __('Add new Prompt') }}
                    @endif
                </div>
            </h4>
        </div>

        @include('livewire._partials.back-to-list',['url'=> route('openai.prompts.index')])

    </div>

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">

                @include('livewire._partials.messages.success')
                @include('livewire._partials.messages.error')

                <form wire:submit.prevent="save" class="mt-5">
                    <div class="grid lg:grid-cols-3 gap-6 ">
                        <div>
                            <x-input-label for="name" :value="__('Name Prompt')" required="true"></x-input-label>
                            <x-text-input wire:model="name" id="name" placeholder="{{__('Name Prompt')}}"
                                          type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="target_model" :value="__('Target model')" required="true"></x-input-label>
                            <select wire:model="target_model" wire:change="onTargetModelChanged" class="form-select" id="target_model">
                                <option value="">{{ __('Select') }}</option>

                                <option value="product">
                                    {{ __('Product') }}
                                </option>

                                <option value="category">
                                    {{ __('Category') }}
                                </option>
                            </select>

                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('target_model')" />


                        </div><!-- div-->

                        <div>
                            <x-input-label for="type" :value="__('Type Prompt')" required="true"></x-input-label>
                            <select wire:model="type" class="form-select" id="type">
                                <option value="" disabled>{{ __('Select') }}</option>

                                @foreach($this->typeOptions as $value => $label)
                                    @if($target_model === 'product' || $value !== 'features')
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach


                            </select>
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('type')" />


                        </div><!-- div-->


                    </div>

                    <div class="grid lg:grid-cols-2 gap-6 mt-5">
                        <div>
                            <x-input-label for="system_prompt" :value="__('System Prompt')" required="true"></x-input-label>
                            <textarea wire:model="system_prompt" placeholder="{{__('System Prompt')}}"
                                      class="w-full border p-2 rounded form-input"  rows="5"></textarea>
                            <x-input-error class="text-red-500 text-xs font-medium"
                                           :messages="$errors->get('system_prompt')" />
                        </div>

                        <div>
                            <x-input-label for="user_prompt_template" :value="__('User Prompt Template')" required="true"></x-input-label>
                            <textarea wire:model="user_prompt_template" placeholder="{{__('User Prompt Template')}}"
                                      class="w-full border p-2 rounded form-input"  rows="5"></textarea>
                            <x-input-error class="text-red-500 text-xs font-medium"
                                           :messages="$errors->get('user_prompt_template')" />


                            <p class="text-xs text-gray-500 mt-2">
                                {!! __('Available placeholders:') . ' ' . $placeholders !!}
                            </p>

                        </div>
                    </div>


                    <div class="grid lg:grid-cols-1 gap-6 mt-5">
                        <div class="flex  justify-start items-center gap-2">
                            @include('livewire._partials.save',['id'=> $id])

                            @include('livewire._partials.back-to-list',['url'=> route('openai.prompts.index')])

                        </div><!-- flex  justify-start items-center gap-2-->
                    </div><!-- grid lg:grid-cols-1 gap-6 mt-5-->
                </form><!-- form-->


            </div>
        </div>
    </div>
</div>
