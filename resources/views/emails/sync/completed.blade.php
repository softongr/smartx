@component('mail::message')
    #  Ο Συγχρονισμός Ολοκληρώθηκε

    Ο συγχρονισμός ολοκληρώθηκε με επιτυχία

    - Total Jobs:{{ $batch->total_jobs }}
    - Finished Jobs: {{ $batch->finished_jobs }}
    - Κατάσταση: {{ ucfirst($batch->status) }}
    - Ημερομηνία: {{ $batch->updated_at->format('d/m/Y H:i') }}

@endcomponent
