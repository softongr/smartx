@component('mail::message')
    # Test Email


    {{ $messageText }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
