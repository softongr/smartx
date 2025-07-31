
@if($user->isSuperAdmin() || $user->can('settings'))
    <li class="hs-accordion menu-item @if(request()->routeIs('settings','settings.products.index',
                'settings.openai.index','settings.sms.index',
                'settings.smtp.index','settings.api_token.index','settings.performance.index', 'settings.myaade.index',
                'profile.edit','rates.index','rate.create','rate.edit','settings.synchronization.indexnpm '))
                                    active @endif">
        <a href="javascript:void(0)"
           class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-e-full px-4 py-2 text-sm font-medium
                                        text-default-700 transition-all hover:bg-default-100 hs-accordion-active:bg-default-100
                                  @if(request()->routeIs('settings','settings.products.index',
                'settings.openai.index','settings.sms.index',
                'settings.smtp.index','settings.api_token.index','settings.performance.index', 'settings.myaade.index',
                'profile.edit','rates.index','rate.create','rate.edit','settings.synchronization.index'))
                                    active @endif">
            <i
                class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Settings</i>
            <span class="menu-text"> {{ __('Settings') }} </span>
            <span
                class="ti ti-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
        </a>

        <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
             @if(request()->routeIs('settings','settings.products.index',
'settings.openai.index','settings.sms.index',
'settings.smtp.index','settings.api_token.index','settings.performance.index', 'settings.myaade.index', 'settings.synchronization.index',
'profile.edit','rates.index','rate.create','rate.edit'))
                 style="display: block;" @endif>
            <ul class="mt-2 space-y-2">
                @if($user->isSuperAdmin() || $user->can('profile.edit'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('profile.edit')"
                                         :active="request()->routeIs('profile.edit')">
                            <span class="menu-text">   {{ __('Profile') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif


                @if($user->isSuperAdmin() || $user->can('settings.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('settings')" :active="request()->routeIs('settings')">
                            <span class="menu-text">{{ __('Generally') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif




                @if($user->isSuperAdmin() || $user->can('rates.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('rates.index')"
                                         :active="request()->routeIs('rates.index')">
                            <span class="menu-text">   {{ __('Rates') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif




            </ul>
        </div>
    </li>
@endif
