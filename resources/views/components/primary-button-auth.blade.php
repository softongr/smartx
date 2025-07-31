<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-4 py-4
text-base font-semibold text-white transition-all duration-200 border border-transparent rounded-md bg-gradient-to-r
                        from-fuchsia-600 to-sky-600 focus:outline-none hover:opacity-80 focus:opacity-80 bg-login']) }}>
    {{ $slot }}
</button>
