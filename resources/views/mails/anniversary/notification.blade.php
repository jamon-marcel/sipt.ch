@component('mail::message')
# Neue Anmeldung – 20 Jahre SIPT

<p>Es wurde eine neue Anmeldung für die Fachtagung «20 Jahre SIPT» registriert.</p>

<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="150">Buchungsnummer:</td>
    <td>{{ $registration['booking_number'] }}</td>
  </tr>
  <tr>
    <td width="150">Name:</td>
    <td>{{ $registration['salutation'] }} {{ $registration['title'] }} {{ $registration['firstname'] }} {{ $registration['name'] }}</td>
  </tr>
  <tr>
    <td width="150">E-Mail:</td>
    <td>{{ $registration['email'] }}</td>
  </tr>
  <tr>
    <td width="150">Telefon:</td>
    <td>{{ $registration['phone'] ?? '-' }}</td>
  </tr>
  <tr>
    <td width="150">Adresse:</td>
    <td>{{ $registration['street'] }} {{ $registration['street_no'] }}, {{ $registration['zip'] }} {{ $registration['city'] }}</td>
  </tr>
  <tr>
    <td width="150">Ticket:</td>
    <td>{{ $registration['ticket_type_label'] }}</td>
  </tr>
  <tr>
    <td width="150">Kosten:</td>
    <td>CHF {{ number_format($registration['cost'], 2, '.', "'") }}</td>
  </tr>
  <tr>
    <td width="150">Frühbucher:</td>
    <td>{{ $registration['is_early_bird'] ? 'Ja' : 'Nein' }}</td>
  </tr>
</table>

@if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'friday_only')
<p><strong>Apéro Freitag:</strong> {{ $registration['apero_friday'] ? 'Ja' : 'Nein' }}</p>
@endif

@if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'saturday_only')
<p><strong>Mittagessen Samstag:</strong> {{ $registration['lunch_saturday'] ? 'Ja' : 'Nein' }}</p>
@endif

<p>Angemeldet am: {{ \Carbon\Carbon::parse($registration['created_at'])->format('d.m.Y H:i') }}</p>
@endcomponent
