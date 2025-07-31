
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn rounded-full  bg-primary text-white gap-3']) }}>
    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
    <span class="ml-2">
    {{ $slot }}
    </span>
</button>
