
<aside id="app-menu"
       class="hs-overlay fixed inset-y-0 start-0 z-[60] hidden w-64 -translate-x-full transform overflow-y-auto
         bg-white transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0
          lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full
          rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true]
          [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">

    <div class="sticky top-0 flex h-16 items-center justify-center px-6">
{{--        <a href="{{route('dashboard')}}" class="flex">--}}
{{--            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="flex h-10">--}}
{{--        </a><!-- a -->--}}
    </div><!-- sticky top-0 flex h-16 items-center justify-center px-6-->

    <div class="hs-accordion-group h-[calc(100%-72px)] p-4 ps-0" data-simplebar>
        <ul class="admin-menu flex w-full flex-col gap-1.5">
            @include('navs.dashboard')
            @include('navs.synchronization')
            @include('navs.newproduct')
{{--            @include('navs.orders')--}}

            @include('navs.openai')
            @include('navs.market')
            @include('navs.teams')
            @include('navs.settings')

        </ul><!-- admin-menu flex w-full flex-col gap-1.5-->
    </div><!-- hs-accordion-group h-[calc(100%-72px)] p-4 ps-0-->
</aside><!-- app-menu-->
