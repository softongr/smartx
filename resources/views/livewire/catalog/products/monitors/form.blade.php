
<div>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Sell</i>
                    {{ __('Add to Monitor') }} {{$object->name}}
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->
    </div>

    <div class="card overflow-hidden p-6 mb-10">
        <form wire:submit.prevent="save" class="mt-5">
            @foreach ($marketplaces as $marketplace)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start border-b pb-4">
                    <div>
                        <x-input-label :for="'url_'.$marketplace->id" :value="$marketplace->name . ' URL'" />
                        <x-text-input
                            id="url_{{ $marketplace->id }}"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="https://..."
                            wire:model.defer="data.{{ $marketplace->id }}.url"
                        />
                        <x-input-error :messages="$errors->get('data.'.$marketplace->id.'.url')" class="mt-1 text-red-500 text-sm" />

                    </div>
                    <div>
                        <x-input-label :for="'price_'.$marketplace->id" :value="$marketplace->name . ' Safety Price'" />
                        <x-text-input
                            id="price_{{ $marketplace->id }}"
                            type="number"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full"
                            placeholder="π.χ. 49.99"
                            wire:model.defer="data.{{ $marketplace->id }}.safety_price"
                        />
                        <x-input-error :messages="$errors->get('data.'.$marketplace->id.'.safety_price')" class="mt-1 text-red-500 text-sm" />

                    </div>
                </div>
            @endforeach

                <div>
                    <x-primary-button>
                        {{ __('Αποθήκευση') }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</div>
