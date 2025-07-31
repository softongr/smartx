@if(auth()->check() &&
                  auth()->user()->isSuperAdmin() || $user->can('products.index'))
    <li class="menu-item">
        <x-nav-link
            :href="route('products.index')" :active="request()->routeIs('products.index')">
            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Add</i>
                {{ __('New Product') }}
        </x-nav-link>
    </li><!-- menu-item-->
@endif
