<div  wire:poll.500ms>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    @if($id)
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Reminder</i>
                        {{ __('Edit Prompt') }}
                        <span class="  whitespace-nowrap inline-block py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                            {{$firstname}} {{$lastname}}
                        </span>

                    @else
                        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">add</i>
                        {{ __('Add new Order') }}
                    @endif
                </div>
            </h4>
        </div>




        @include('livewire._partials.back-to-list',['url'=> route('ordersphone.index')])

    </div>

    <div class="card overflow-hidden p-6">

                @include('livewire._partials.messages.success')
                @include('livewire._partials.messages.error')

                <form wire:submit.prevent="save">

                    {{-- Παραστατικό (Απόδειξη ή Τιμολόγιο) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Τύπος Παραστατικού</label>
                        <div class="flex flex-col gap-2">
                            <div class="form-check">
                                <input type="radio"
                                       class="form-radio text-primary"
                                       id="document_type_receipt"
                                       name="document_type"
                                       value="receipt"
                                       wire:model="document_type"
                                       @checked($document_type === 'receipt')
                                       wire:click="selectDocumentType('receipt')">
                                <label for="document_type_receipt" class="ms-1.5">Απόδειξη</label>
                            </div>

                            <div class="form-check">
                                <input type="radio"
                                       class="form-radio text-primary"
                                       id="document_type_invoice"
                                       name="document_type"
                                       value="invoice"
                                       wire:model="document_type"
                                       @checked($document_type === 'invoice')
                                       wire:click="selectDocumentType('invoice')">
                                <label for="document_type_invoice" class="ms-1.5">Τιμολόγιο</label>
                            </div>
                        </div>
                    </div>



                </form><!-- form-->


            </div>

    @if($document_type == 'receipt')
        @include('livewire.orders.phone.document_type.receipt')
    @else
        @include('livewire.orders.phone.document_type.invoice')
    @endif


</div>
