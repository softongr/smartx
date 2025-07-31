@if(auth()->check() &&
                  auth()->user()->isSuperAdmin() || $user->can('dashboard'))
    <li class="menu-item">
        <x-nav-link
            :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Dashboard</i>
            {{ __('Dashboard') }}
        </x-nav-link>
    </li><!-- menu-item-->
@endif
