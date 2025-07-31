<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
          <div>
                <h4 class="text-slate-900 text-lg font-medium mb-2">
                    <div class="flex justify-start items-center gap-2">
                        @if($id)
                            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Sell</i>
                            {{ __('Edit Product') }}

                        @else
                            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">add</i>
                            {{ __('Add new product') }}
                        @endif
                    </div>
                </h4>
            </div>

            @if(auth()->check() &&
                        auth()->user()->isSuperAdmin() || $user->can('products.index'))
                        @include('livewire._partials.back-to-list',['url'=> route('products.index')])
            @endif
        </div>

        @include('livewire._partials.sync_running')
        <div class="card overflow-hidden p-6">
            @if(count($marketplaces))
                @include('livewire._partials.messages.success')
                @include('livewire._partials.messages.error')
                @include('livewire.catalog.products.form.form')
            @else
                @include('livewire.catalog.products._partials.no-available-markeplaces')
            @endif
        </div>
    @include('livewire._partials.loading' , ['text' => __('Process'), 'events' => 'saveWithScrape'])
</div>



