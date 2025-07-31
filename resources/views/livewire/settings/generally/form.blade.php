<form wire:submit.prevent="save" class="mt-5">
    <div class="grid lg:grid-cols-2 gap-6">

        <div>
            <x-input-label for="app_name" :value="__('Application Name')"></x-input-label>
            <x-text-input wire:model="app_name" id="app_name" placeholder="{{__('Application Name')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('app_name')" />
            <div class="mt-2">


                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>

                    <i>
                        {{ __('If you change the application name, you will be automatically logged out and need to log in again.') }}
                    </i>
                </small>
            </div>



        </div><!-- div-->


        <div>
            <x-input-label for="email_notification" :value="__('Email Notification')" required="true"></x-input-label>
            <x-text-input wire:model="email_notification" id="email_notification" placeholder="{{__('Email Notification')}}"
                          type="text" class="mt-1 block w-full" />
            <x-input-error class="text-red-500 text-xs font-medium" :messages="$errors->get('email_notification')" />

            <div class="mt-2">


                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>

                    <i>
                        {{ __('The email you enter here will be used to receive notifications about important system updates, such as synchronizations, price changes, etc.') }}
                    </i>
                </small>
            </div>
        </div><!-- div-->



    </div>
<hr class="mt-5">
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
        <div>
            <div class="flex items-center">
                <input class="form-switch" type="checkbox" role="switch"
                       id="notify_on_login" wire:click="toggleNotifyOnLogin"  wire:model.defer="notify_on_login">




                <x-input-label class="ms-1.5" for="notify_on_login"
                               :value="__('Notify on every user login')"></x-input-label>


            </div>

            <div class="mt-2">
                <small class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <i>
                        {{ __('Enable this option to receive an email each time a user logs into the system.') }}
                    </i>
                </small>
            </div>

        </div>


        @if($notify_on_login)
            <div>


            <div class="space-y-4">
                <p class="text-sm font-semibold text-gray-700">
                   {{ __('Send notification via:') }}
                </p>

                <div class="flex items-center items-center gap-5">
                    {{-- Ειδοποίηση με SMS --}}
                    <div class="flex items-center">
                        <input
                            class="form-switch"
                            type="checkbox"
                            role="switch"
                            id="notify_on_login_sms"
                            wire:model.defer="notify_on_login_sms"
                        >
                        <x-input-label for="notify_on_login_sms" class="ms-1.5" :value="__('Notify SMS')" />
                    </div>
                    {{-- Ειδοποίηση με Email --}}
                    <div class="flex items-center">
                        <input
                            class="form-switch"
                            type="checkbox"
                            role="switch"
                            id="notify_on_login_email"
                            wire:model.defer="notify_on_login_email"
                        >
                        <x-input-label for="notify_on_login_email" class="ms-1.5" :value="__('Notify Email')" />
                    </div>
                </div>




            </div>
            </div>
        @endif

    </div>



    @if(!is_sync_running())
        <div class="grid lg:grid-cols-3 gap-6 mt-5">
            <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
                <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Save</i>
                <span class="ml-2">
                            {{ __('Save') }}
                        </span><!-- ml-2 -->
            </button><!-- btn rounded-full  bg-primary text-white gap-3-->
        </div>
    @else
        <div wire:poll.500ms class="mt-5">
        @include('livewire._partials.sync_running')

        </div>
    @endif
</form>
