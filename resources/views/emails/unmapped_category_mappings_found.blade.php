@component('mail::message')
    # ⚠️ Υπάρχουν μη αντιστοιχισμένες εγγραφές CategoryMapping

    @foreach ($ids as $id)
        - Mapping ID: **{{ $id }}**
    @endforeach


    Παρακαλούμε φροντίστε για την αντιστοίχιση των κατηγοριών ώστε να συνεχιστεί η διαδικασία κανονικά.

    Ευχαριστούμε,
    {{ config('app.name') }}
@endcomponent
