<div  wire:poll.500ms>



    @include('livewire.settings.nav')
    <div class="card overflow-hidden p-6">


        @include('livewire._partials.messages.success')
        @include('livewire._partials.messages.error')
        @include('livewire.settings.sms.form')

        @include('livewire._partials.loading' , ['text' => __('Process'), 'events' => 'save, testSms'])








    </div>
</div>
