@component('mail::message')
    # Νέα Σύνδεση Χρήστη

    Ο παρακάτω χρήστης συνδέθηκε στο σύστημα:

    ---

    **👤 Όνομα:** {{ $name }}
    **📧 Email:** {{ $email }}
    **🌐 IP Διεύθυνση:** {{ $ip }}
    **📍 Τοποθεσία:** {{ $location ?? '—' }}
    **📅 Ώρα:** {{ $time }}
    **🖥️ Browser:** {{ $user_agent ?? '—' }}

    ---

    @component('mail::footer')
        Αυτό το μήνυμα δημιουργήθηκε αυτόματα από το σύστημα.
    @endcomponent
@endcomponent
