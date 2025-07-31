<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                    </svg>

                    {{ __('Users Logs') }}
                    <span
                        class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-indigo-500 text-white rounded me-1">{{$count}}</span>
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->



    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->
    <div class="card overflow-hidden p-6">

        @if($count)
            <div class="flex mb-5 gap-2 justify-start items-center">
                @include('livewire._partials.search')
            </div>
        @endif

        @include('livewire._partials.messages.error')

        @if(count($items))
            @include('livewire.team.logs._partials.data')
        @else
            @include('livewire._partials.nodata' ,['url' => ''])
        @endif

        @if(count($items))
            <div class="mt-5 bg-white">
                {{$items->links()}}
            </div>
        @endif

    </div>

</div>
