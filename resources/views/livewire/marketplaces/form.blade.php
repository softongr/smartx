<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    @if($id)
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Storefront</i>
                        {{ __('Edit marketplace') }}
                        <span class="  whitespace-nowrap inline-block py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                            {{$name}}
                        </span>

                    @else
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">add</i>
                        {{ __('Add new marketplace') }}
                    @endif
                </div>
            </h4>
        </div>
        @include('livewire._partials.back-to-list',['url'=> route('marketplaces.index')])


    </div>

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">

                @include('livewire._partials.messages.success')
                @include('livewire._partials.messages.error')



                <form wire:submit.prevent="save" class="mt-5">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" required="true"></x-input-label>
                            <x-text-input wire:model="name" id="name" placeholder="{{__('Name')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('name')" />
                        </div><!-- div-->



                        <div>
                            <x-input-label for="link" :value="__('Link')" required="true"></x-input-label>
                            <x-text-input wire:model="url_pattern" id="email" placeholder="{{__('Link')}}" type="text" class="mt-1 block w-full" />
                            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('url_pattern')" />
                        </div><!-- div-->

                    </div>

                    <div class="grid lg:grid-cols-2 gap-6 mt-5 ">
                        <div class="flex items-center">
                            <input class="form-switch"
                                   type="checkbox"
                                   role="switch"
                                   wire:click="toggleHasCommission"
                                   @checked($has_commission)
                                   id="has_profit"
                                   wire:model.defer="has_commission"
                            >
                            <x-input-label class="ms-1.5" for="has_profit"
                                           :value="__('Has commission')"
                            >
                            </x-input-label>
                        </div>

                        @if($has_commission)
                            <div>
                                <x-input-label for="commission" :value="__('Commission')" required="true"></x-input-label>
                                <x-text-input wire:model="commission" id="commission" placeholder="{{__('Commission')}}" type="text" class="mt-1 block w-full" />
                                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('commission')" />
                            </div><!-- div-->

                            <div>
                                <x-input-label for="minimum_profit_margin" :value="__('Minimum Profit Margin')" required="true"></x-input-label>
                                <x-text-input wire:model="minimum_profit_margin" id="minimum_profit_margin" placeholder="{{__('Minimum Profit Margin')}}" type="text" class="mt-1 block w-full" />
                                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('minimum_profit_margin')" />
                            </div><!-- div-->
                        @endif
                    </div>


                        <div class="grid lg:grid-cols-1 gap-6 mt-5">
                            <div class="flex  justify-start items-center gap-2">
                                @include('livewire._partials.save',['id'=> $id])

                                @include('livewire._partials.back-to-list',['url'=> route('marketplaces.index')])

                            </div><!-- flex  justify-start items-center gap-2-->
                        </div><!-- grid lg:grid-cols-1 gap-6 mt-5-->

                </form><!-- form-->


            </div>
        </div>
    </div>
</div>
