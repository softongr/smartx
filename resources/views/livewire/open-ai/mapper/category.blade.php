<div  wire:poll.500ms>
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9 3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5 5.25 5.25" />
                    </svg>
                    {{ __('Category Mapper') }}
                </div>

            </h4>
        </div>


        @if($user->isSuperAdmin() || $user->can('openai.prompts.create'))
            <div>
                @include('livewire._partials.button_create',[
                    'text' => __('Add new'), 'url'=> route('openai.prompts.create')])
            </div>
        @endif

    </div>

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="p-6">

                @if(count($categoryPrompts))
                    @include('livewire._partials.messages.success')
                    @include('livewire._partials.messages.error')
                    @include('livewire.open-ai.mapper.form.category')
                @else
                    <div class="flex justify-start items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        <strong>{{ __('There are no available prompts to map.') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
