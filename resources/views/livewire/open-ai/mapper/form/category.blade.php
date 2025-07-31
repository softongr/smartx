<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-3 gap-6 ">
        @foreach($categoryPrompts as $prompt)
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <label class="w-60 font-medium text-sm text-gray-700 mb-2">
                    {{ is_array($prompt) ? $prompt['name'] : $prompt->name }}
                    <span class="text-gray-400 text-xs">
                                            ({{ is_array($prompt) ? $prompt['type'] : $prompt->type }})</span>
                </label>

                <select  wire:model="categoryPromptFieldMapping.{{ $prompt->id }}"
                         class="form-select w-full md:w-1/2">
                    <option value="">{{ __('Καμία αντιστοίχιση') }}</option>
                    @foreach($categoryFields as $field)

                        <option value="{{ $field }}">{{ $field }}</option>
                    @endforeach
                </select>

                @if(isset($categoryPromptFieldMapping[$prompt->id]))
                    <span class="text-xs text-gray-500">
                            → $category->{{ $categoryPromptFieldMapping[$prompt->id] }}
                        </span>
                @endif
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
            <span class="ml-2">
                        {{ __('Save') }}
                    </span><!-- ml-2 -->
        </button><!-- btn rounded-full  bg-primary text-white gap-3-->
    </div>
</form><!-- form-->
