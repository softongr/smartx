
@if($user->isSuperAdmin() || $user->can('employees.index') || $user->can('permissions.index') || $user->can('roles.index'))
    <li class="hs-accordion menu-item @if(request()->routeIs('roles.index','role.create','role.edit','role.permissions','role.delete',
 'employees.index','employee.create','employee.edit','users.logs','employee.delete','permissions.index','permission.create','permission.edit'))
                                    active @endif">
        <a href="javascript:void(0)"
           class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-e-full px-4 py-2 text-sm font-medium
                                        text-default-700 transition-all hover:bg-default-100 hs-accordion-active:bg-default-100
                                   @if(request()->routeIs('roles.index','role.create','role.edit','role.permissions','role.delete',
 'employees.index','employee.create','employee.edit','employee.delete', 'users.logs','permissions.index','permission.create','permission.edit'))
                                    active @endif">
            <i
                class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Groups</i>
            <span class="menu-text"> {{ __('Teams') }} </span>
            <span
                class="ti ti-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
        </a>

        <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
             @if(request()->routeIs('roles.index','role.create','role.edit','role.permissions','role.delete',
'employees.index','employee.create','employee.edit', 'users.logs',
'employee.delete','permissions.index','permission.create','permission.edit'))
                 style="display: block;" @endif>
            <ul class="mt-2 space-y-2">

                @if($user->isSuperAdmin() || $user->can('employees.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('employees.index')"
                                         :active="request()->routeIs('employees.index')">
                            <span class="menu-text">{{ __('Employees') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif

                @if($user->isSuperAdmin() || $user->can('roles.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('roles.index')"
                                         :active="request()->routeIs('roles.index')">
                            <span class="menu-text">{{ __('Roles') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif


                @if($user->isSuperAdmin() || $user->can('permissions.index'))
                    <li class="menu-item">
                        <x-dropdown-link :href="route('permissions.index')"
                                         :active="request()->routeIs('permissions.index')">
                            <span class="menu-text">{{ __('Permissions') }}</span>
                        </x-dropdown-link>
                    </li>
                @endif



                    @if($user->isSuperAdmin() || $user->can('users.logs'))
                        <li class="menu-item">
                            <x-dropdown-link :href="route('users.logs')"
                                             :active="request()->routeIs('users.logs')">
                                <span class="menu-text">{{ __('Users Logs') }}</span>
                            </x-dropdown-link>
                        </li>
                    @endif



            </ul>
        </div>
    </li>
@endif

