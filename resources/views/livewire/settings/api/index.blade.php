<div  wire:poll.500ms>
    @include('livewire.settings.nav', [ 'user' => auth()->user()])
    <div class="card overflow-hidden p-6">
        @include('livewire._partials.messages.success')
        @include('livewire._partials.messages.error')
        @include('livewire.settings.api.form')

        @include('livewire._partials.loading' , ['text' => __('My'), 'events' => 'save'])
    </div><!-- card overflow-hidden p-6-->
</div>
