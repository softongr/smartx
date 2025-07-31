@if(auth()->check() &&
                  auth()->user()->isSuperAdmin() || $user->can('docs.index'))
    <li class="menu-item">
        <x-nav-link
            :href="route('docs.index')" :active="request()->routeIs('docs.index')">
            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Dashboard</i>
            {{ __('App Docs') }}
        </x-nav-link>
    </li><!-- menu-item-->
@endif
