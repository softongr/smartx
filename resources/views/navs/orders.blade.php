@if(auth()->check() && auth()->user()->isSuperAdmin()
              || $user->can('ordersphone.index'))
    <li class="hs-accordion menu-item @if(request()->routeIs('ordersphone.index','orderphone.create','orderphone.edit'))
                                    active @endif">
        <a href="javascript:void(0)"
           class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-e-full px-4 py-2 text-sm font-medium
                                        text-default-700 transition-all hover:bg-default-100 hs-accordion-active:bg-default-100
                                  @if(request()->routeIs('ordersphone.index','orderphone.create','orderphone.edit'))
                                    active @endif">
            <i
                class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Orders</i>
            <span class="menu-text"> {{ __('Orders') }} </span>
            <span
                class="ti ti-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
        </a>

        <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300" @if(request()->routeIs('ordersphone.index','orderphone.create','orderphone.edit'))
            style="display: block;" @endif>
            <ul class="mt-2 space-y-2">

                @if(auth()->check() && auth()->user()->isSuperAdmin() || $user->can('ordersphone.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('ordersphone.index')"
                                         :active="request()->routeIs('ordersphone.index')">
                            <span class="menu-text">{{ __('Phone Orders') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif


            </ul>
        </div>
    </li>
@endif
