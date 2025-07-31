
@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full py-4 ps-10 pe-4 text-black placeholder-gray-500 transition-all duration-200 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-sky-600 focus:bg-white caret-sky-600']) }}>
