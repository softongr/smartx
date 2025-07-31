

    <div class="flex items-center">
        <input class="form-switch" type="checkbox" role="switch"
               id="openai_auto_apply_prompts"
               wire:model.defer="openai_auto_apply_prompts"
               wire:click="togglePromptSetting">

        <x-input-label class="ms-1.5" for="openai_auto_apply_prompts"
                       :value="__('OpenAI Auto Apply Prompts')"></x-input-label>
    </div>






        <div class="grid lg:grid-cols-2 gap-6 mt-5 mb-5">

            <div class="relative">
                <x-input-label for="meta_title" :value="__('Meta title')" />

                <div class="relative">
        <textarea @if($openai_auto_apply_prompts) readonly @endif
        wire:model="meta_title"
                  class="w-full border p-2 rounded form-input min-h-[80px] pr-10"
                  rows="2">{{$meta_title}}</textarea>

                    {{-- Loader overlay στο κέντρο του textarea --}}
                    <div wire:loading wire:target="generateField('meta_title')"
                         class="absolute inset-0 flex items-center justify-center bg-white/70 rounded">
                        <svg class="animate-spin w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </div>
                </div>

                @error('meta_title')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                @if(!$openai_auto_apply_prompts)
                    <button type="button"
                            wire:click="generateField('meta_title')"
                            class="bg-gray-200 hover:bg-gray-300 mt-2 text-xs text-gray-800 px-2 py-1 rounded flex items-center gap-2">
                        {{ __('Generate') }}
                    </button>
                @endif

                @if($openai_auto_apply_prompts)
                    <p class="text-xs text-gray-500 mt-2">

                        {{ __('The content will be generated automatically via AI.') }}

                    </p>

                @endif
            </div>







            <div class="relative">
                <x-input-label for="meta_description" :value="__('Meta Description')" />
                <div class="relative">
                    <textarea @if($openai_auto_apply_prompts) readonly @endif wire:model="meta_description"
                  class="w-full border p-2 rounded form-input min-h-[80px] pr-10"
                  rows="2">{{$meta_description}}</textarea>
                    <div wire:loading wire:target="generateField('meta_description')"
                         class="absolute inset-0 flex items-center justify-center bg-white/70 rounded">
                        <svg class="animate-spin w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </div>
                </div>

                @error('meta_description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                @if(!$openai_auto_apply_prompts)
                    <button type="button"
                            wire:click="generateField('meta_description')"
                            class="bg-gray-200 hover:bg-gray-300 mt-2 text-xs text-gray-800 px-2 py-1 rounded flex items-center gap-2">
                        {{ __('Generate') }}
                    </button>
                @endif

                @if($openai_auto_apply_prompts)
                    <p class="text-xs text-gray-500 mt-2">

                        {{ __('The content will be generated automatically via AI.') }}

                    </p>

                @endif
            </div>





            <div class="relative">
                <x-input-label for="short_description" :value="__('Short Description')" />

                <div class="relative">
        <textarea @if($openai_auto_apply_prompts) readonly @endif
        wire:model="short_description"
                  class="w-full border p-2 rounded form-input min-h-[80px] pr-10"
                  rows="6">{{$short_description}}</textarea>

                    {{-- Loader overlay στο κέντρο του textarea --}}
                    <div wire:loading wire:target="generateField('short_description')"
                         class="absolute inset-0 flex items-center justify-center bg-white/70 rounded">
                        <svg class="animate-spin w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </div>
                </div>

                @error('short_description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                @if(!$openai_auto_apply_prompts)
                    <button type="button"
                            wire:click="generateField('short_description')"
                            class="bg-gray-200 hover:bg-gray-300 mt-2 text-xs text-gray-800 px-2 py-1 rounded flex items-center gap-2">
                        {{ __('Generate') }}
                    </button>
                @endif

                @if($openai_auto_apply_prompts)
                    <p class="text-xs text-gray-500 mt-2">

                        {{ __('The content will be generated automatically via AI.') }}

                    </p>

                @endif
            </div>





            <div class="relative">
                <x-input-label for="description" :value="__('Description')" />

                <div class="relative">
        <textarea @if($openai_auto_apply_prompts) readonly @endif
        wire:model="description"
                  class="w-full border p-2 rounded form-input min-h-[80px] pr-10"
                  rows="6">{{$description}}</textarea>

                    {{-- Loader overlay στο κέντρο του textarea --}}
                    <div wire:loading wire:target="generateField('description')"
                         class="absolute inset-0 flex items-center justify-center bg-white/70 rounded">
                        <svg class="animate-spin w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </div>
                </div>

                @error('description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                @if(!$openai_auto_apply_prompts)
                    <button type="button"
                            wire:click="generateField('description')"
                            class="bg-gray-200 hover:bg-gray-300 mt-2 text-xs text-gray-800 px-2 py-1 rounded flex items-center gap-2">
                        {{ __('Generate') }}
                    </button>
                @endif

                @if($openai_auto_apply_prompts)
                    <p class="text-xs text-gray-500 mt-2">

                        {{ __('The content will be generated automatically via AI.') }}

                    </p>

                @endif
            </div>






</div>


<form wire:submit.prevent="saveDetails">








        <button type="submit" class="btn btn-lg bg-primary text-white gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>



            <span class="ml-2">
                        {{ __('Next step') }}
                    </span><!-- ml-2 -->
        </button><!-- btn rounded-full  bg-primary text-white gap-3-->
</form>
