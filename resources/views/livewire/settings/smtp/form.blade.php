<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-4 gap-6">

        <div>
            <x-input-label for="mail_mailer" :value="__('Mailer')" required="true"></x-input-label>
            <x-text-input wire:model="mail_mailer" id="mail_mailer" placeholder="{{__('Store Name')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('mail_mailer')" />
        </div><!-- div-->


        <div>
            <x-input-label for="mail_host" :value="__('SMTP Host')" required="true"></x-input-label>
            <x-text-input wire:model="mail_host" id="mail_host" placeholder="{{__('SMTP Host')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('mail_host')" />

        </div><!-- div-->




        <div>
            <x-input-label for="mail_port" :value="__('SMTP Port')" required="true"></x-input-label>
            <x-text-input wire:model="mail_port" id="mail_port" placeholder="{{__('SMTP Port')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_port')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_username" :value="__('SMTP Username')" required="true"></x-input-label>
            <x-text-input wire:model="mail_username" id="mail_username" placeholder="{{__('SMTP Username')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_username')" />
        </div><!-- div-->


    </div>

    <div class="grid lg:grid-cols-4 gap-6 mt-5">
        <div>
            <x-input-label for="mail_password" :value="__('SMTP Password')" required="true"></x-input-label>
            <x-text-input wire:model="mail_password" id="mail_password" placeholder="{{__('SMTP Password')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_password')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_encryption" :value="__('Encryption (tls/ssl)')" required="true"></x-input-label>
            <x-text-input wire:model="mail_encryption" id="mail_encryption" placeholder="{{__('Encryption (tls/ssl)')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_encryption')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_from_address" :value="__('From Email')" required="true"></x-input-label>
            <x-text-input wire:model="mail_from_address" id="mail_from_address" placeholder="{{__('From Email')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_from_address')" />
        </div><!-- div-->

        <div>
            <x-input-label for="mail_from_name" :value="__('From Name')" required="true"></x-input-label>
            <x-text-input wire:model="mail_from_name" id="mail_from_name" placeholder="{{__('From Name')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium pb-5" :messages="$errors->get('mail_from_name')" />
        </div><!-- div-->



    </div>


    @if(!is_sync_running())
        <div class="grid lg:grid-cols-2 gap-6 mt-5" style="margin-top: 50px;">
            <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3">
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                <span class="ml-2">{{ __('Save') }}</span><!-- ml-2 -->
            </button><!-- btn rounded-full  bg-primary text-white gap-3-->



            @if($mail_mailer && $mail_host && $mail_username && $mail_password && $mail_encryption && $mail_from_address  && $mail_from_name)
                <div class="grid lg:grid-cols-2 gap-5">
                    <div>
                        <x-text-input wire:model="test_email" id="test_email"
                                      placeholder="{{__('Test email')}}"
                                      type="text" class=" block w-full"
                                      style="height: 100%"
                        />
                        <x-input-error class="text-red-500 text-xs font-medium"
                                       :messages="$errors->get('test_email')"/>
                    </div> <!-- div -->
                    <div>
                        <button style="height: 100%;width: 100%"
                                wire:click="sendTestEmail" type="button"
                                class="btn  bg-primary/25 text-primary hover:bg-primary hover:text-white">
                            <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Send</i>
                            <span class="ml-1">{{ __('Send Test Email') }}</span>
                        </button>
                    </div> <!-- div -->
                </div><!-- grid lg:grid-cols-2 gap-5-->

            @endif
        </div>


    @else
        <div wire:poll.500ms class="mt-5">
            @include('livewire._partials.sync_running')

        </div>
    @endif








</form>



