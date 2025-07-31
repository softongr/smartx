@if(auth()->check() && auth()->user()->isSuperAdmin() || $user->can('openai.prompts.index') || $user->can('settings.openai.index'))
    <li class="hs-accordion menu-item @if(request()->routeIs('openai.prompts.index',
'openai.prompts.create','openai.prompts.edit','openai.prompts.delete' ,'openai.mapper.product','openai.mapper.category'))
                                    active @endif">
        <a href="javascript:void(0)"
           class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-e-full px-4 py-2 text-sm font-medium
                                        text-default-700 transition-all hover:bg-default-100 hs-accordion-active:bg-default-100
                                    @if(request()->routeIs('openai.prompts.index',
'openai.prompts.create','openai.prompts.edit','openai.prompts.delete', 'openai.mapper.product','openai.mapper.category'))
                                    active @endif">
            <i
                class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Chat</i>
            <span class="menu-text"> {{ __('AI Tools') }} </span>
            <span
                class="ti ti-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
        </a>

        <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
             @if(request()->routeIs('openai.prompts.index','openai.prompts.create',
'openai.prompts.edit','openai.prompts.delete','openai.mapper.product','openai.mapper.category'))
                 style="display: block;" @endif>
            <ul class="mt-2 space-y-2">

                @if(auth()->check() && auth()->user()->isSuperAdmin() || $user->can('openai.prompts.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('openai.prompts.index')"
                                         :active="request()->routeIs('openai.prompts.index')">
                            <span class="menu-text">{{ __('Prompts (OpenAI)') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif

                @if(auth()->check() && auth()->user()->isSuperAdmin() || $user->can('settings.openai.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('settings.openai.index')"
                                         :active="request()->routeIs('settings.openai.index')">
                            <span class="menu-text">{{ __('Settings') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif


                    @if(auth()->check() && auth()->user()->isSuperAdmin() || $user->can('openai.mapper.product'))
                        <li class="menu-item">
                            <x-dropdown-link :href="route('openai.mapper.product')"
                                             :active="request()->routeIs('openai.mapper.product')">
                                <span class="menu-text">{{ __('Product Mapper') }}</span>
                            </x-dropdown-link>
                        </li>
                    @endif

                    @if(auth()->check() && auth()->user()->isSuperAdmin() || $user->can('openai.mapper.category'))
                        <li class="menu-item">
                            <x-dropdown-link :href="route('openai.mapper.category')"
                                             :active="request()->routeIs('openai.mapper.category')">
                                <span class="menu-text">{{ __('Category Mapper') }}</span>
                            </x-dropdown-link>
                        </li>
                    @endif

            </ul>
        </div>
    </li>
@endif

