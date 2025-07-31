<div class="mb-5">


    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
        @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.index'))

            <li class="me-2">
                <a href="{{route('settings')}}"
                   class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                           @if( $activeTab ==='generally' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600
                              hover:border-gray-300 dark:hover:text-gray-300' @endif">
                    {{ __('Generally') }}
                </a>
            </li>
        @endif
            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.products.index'))

            <li class="me-2">
                <a href="{{route('settings.products.index')}}"
                   class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                           @if( $activeTab ==='products' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600
                               hover:border-gray-300 dark:hover:text-gray-300'
                                @endif">


                    {{ __('Products Settings') }}
                </a>
            </li>






        @endif

            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.openai.index'))

            <li class="me-2">
                <a href="{{route('settings.openai.index')}}"
                   class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='openai' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                    {{ __('OpenAI Settings') }}
                </a>
            </li>
        @endif


            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.sms.index'))

                <li class="me-2">
                    <a href="{{route('settings.sms.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='sms' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('SMS') }}
                    </a>
                </li>
            @endif



           @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.smtp.index'))
                <li class="me-2">
                    <a href="{{route('settings.smtp.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='smtp' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('SMTP') }}
                    </a>
                </li>
            @endif



            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.api_token.index'))
                <li class="me-2">
                    <a href="{{route('settings.api_token.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='api_token' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('API Key') }}
                    </a>
                </li>
            @endif

            @if(optional($user)->isSuperAdmin()
                    || optional($user)->can('settings.performance.index'))
            <li class="me-2">
                    <a href="{{route('settings.performance.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='performance' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">

                        {{ __('Performance') }}
                    </a>
                </li>
            @endif
            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.myaade.index'))
                <li class="me-2">
                    <a href="{{route('settings.myaade.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='myaade' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">
                        {{ __('myAADE') }}
                    </a>
                </li>
            @endif

            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.synchronization.index'))
                <li class="me-2">
                    <a href="{{route('settings.synchronization.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='synchronization' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">
                        {{ __('Synchronization') }}
                    </a>
                </li>
            @endif

            @if(optional($user)->isSuperAdmin() || optional($user)->can('settings.ordersphone.index'))
                <li class="me-2">
                    <a href="{{route('settings.ordersphone.index')}}"
                       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group
                             @if( $activeTab ==='phone_orders' )
                                'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500'
                              @else 'border-transparent text-gray-400 cursor-not-allowed hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' @endif">
                        {{ __('Phone Orders') }}
                    </a>
                </li>
            @endif
    </ul>
</div>
