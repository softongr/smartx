<div class="card overflow-hidden p-6 mt-5">
<div class="grid lg:grid-cols-2 gap-6  ">
    <div>
        <x-input-label for="vatnumber" :value="__('Vat Number')" required="true"></x-input-label>
        <x-text-input wire:model.live="vatnumber" id="vatnumber" placeholder="{{__('Vat Number')}}"
                      type="text" class="mt-1 block w-full"       maxlength="9" />
        <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('vatnumber')" />
    </div>
    @if($this->showAadeButton)
        <div class="flex items-end">
            <button type="button"
                    wire:click="aade"
                    class="btn rounded-full bg-dark/25 text-slate-900 hover:bg-dark hover:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                {{ __('AADE') }}
            </button>

        </div>
    @endif

    @if($error)
        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">
              {{$error_message}}
        </span>

    @endif

</div>

</div>

@if($flag)
    <div class="card overflow-hidden p-6 mt-5">
        <div class="grid lg:grid-cols-4 gap-6 mt-5 ">
           <div>
                <x-input-label for="firstname" :value="__('Firstname')" required="true"></x-input-label>
                <x-text-input wire:model="firstname" id="firstname" placeholder="{{__('Firstname')}}"
                              type="text" class="mt-1 block w-full"/>
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('firstname')" />
            </div>
            <div>
                <x-input-label for="lastname" :value="__('Lastname')" required="true"></x-input-label>
                <x-text-input wire:model="lastname" id="lastname" placeholder="{{__('Lastname')}}"
                              type="text" class="mt-1 block w-full"/>
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('lastname')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')"></x-input-label>
                <x-text-input wire:model="email" id="email" placeholder="{{__('Email')}}"
                              type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="mobile" :value="__('Mobile')"  required="true"></x-input-label>
                <x-text-input wire:model="mobile" id="mobile" placeholder="{{__('Mobile')}}"
                              type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('mobile')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone')"></x-input-label>
                <x-text-input wire:model="phone" id="phone" placeholder="{{__('Phone')}}"
                              type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="address" :value="__('Address')"></x-input-label>
                <x-text-input wire:model="address" id="address" placeholder="{{__('Address')}}"
                              type="text" class="mt-1 block w-full" />
                <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('address')" />
            </div>
        </div>
    </div>
@endif
