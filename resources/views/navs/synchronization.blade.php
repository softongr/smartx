





@if($user->isSuperAdmin() || $user->can('synchronization') || $user->can('synchronization.logs.index'))
    <li class="hs-accordion menu-item @if(request()->routeIs('synchronization','synchronization.logs.index'))
                                    active @endif">
        <a href="javascript:void(0)"
           class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-e-full px-4 py-2 text-sm font-medium
                                        text-default-700 transition-all hover:bg-default-100 hs-accordion-active:bg-default-100
                                  @if(request()->routeIs('synchronization','synchronization.logs.index'))
                                    active @endif">
            <i
                class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Settings</i>
            <span class="menu-text"> {{ __('Synchronization') }} </span>
            <span
                class="ti ti-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
        </a>

        <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
             @if(request()->routeIs('synchronization','synchronization.logs.index'))
                 style="display: block;" @endif>


            <ul class="mt-2 space-y-2">
                @if($user->isSuperAdmin() || $user->can('synchronization'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('synchronization')"
                                         :active="request()->routeIs('synchronization')">
                            <span class="menu-text">   {{ __('Synchronization') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif




                    @if($user->isSuperAdmin() || $user->can('synchronization.logs.index'))
                        <li class="menu-item">
                            <x-dropdown-link :href="route('synchronization.logs.index')"
                                             :active="request()->routeIs('synchronization.logs.index')">
                                <span class="menu-text">   {{ __('Logs') }}</span>
                            </x-dropdown-link>
                        </li>
                    @endif









            </ul>
        </div>
    </li>
@endif
