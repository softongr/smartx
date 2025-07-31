@props(['value', 'required' => false, "note"=> false])


<label {{ $attributes->merge(['class' => 'text-base font-medium text-gray-900']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif


</label>

