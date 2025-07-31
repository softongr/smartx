<!-- The select input field -->
<select wire:model="{{ $name }}" class="form-select" id="{{ $name }}">
    <!-- Option for "All stores" or placeholder -->
    <option selected value="0">{{ $placeholder ?? __('All stores') }}</option>

    <!-- Loop through the options to generate the store options -->
    @foreach($options as $option)
        <option value="{{ $option->id }}" {{ $option->id == $selectedValue ? 'selected' : '' }}>
            {{ $option->name }}
        </option>
    @endforeach
</select>
