
<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Sell</i>
                    {{ __('Products') }}
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-indigo-500 text-white rounded me-1">{{$count}}</span>
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->


        <div>
            @include('livewire._partials.button_create',[
                'text' => __('Add new'), 'url'=> route('product.create')])
        </div>

    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->



    <div wire:poll.500ms>

        @include('livewire.catalog.products.nav')
        <div class="card overflow-hidden p-6">
            @if($count)
                @include('livewire._partials.search')
            @endif
            @include('livewire._partials.messages.success')
            @include('livewire._partials.messages.error')

            @if(count($items))

                    @switch($step)
                        @case('1')
                            @include('livewire.catalog.products._tables._step_1')
                            @break

                        @case('2')
                            @include('livewire.catalog.products._tables._step_2')
                            @break

                        @case('4')

                            @include('livewire.catalog.products._partials.category-missing-maping')
                            @include('livewire.catalog.products._tables._step_3')

                            @break

                        @default
                            <p>{{ __('Δεν υπάρχει πίνακας για αυτό το βήμα.') }}</p>
                    @endswitch


            @else
                @include('livewire._partials.nodata' ,['url' => ''])
            @endif

            @if(count($items))
                <div class="mt-5 bg-white">
                    {{$items->links()}}
                </div>
            @endif
        </div><!-- card overflow-hidden p-6-->
    </div>
</div>
