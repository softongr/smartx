@props(['value', 'required' => false, "note"=> false])


<label {{ $attributes->merge(['class' => 'text-gray-800 text-sm font-medium inline-block mb-2']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif


</label>

