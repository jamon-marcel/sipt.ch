@component('mail::message')
# Neue Anmeldung – 20 Jahre SIPT

<p>Es wurde eine neue Anmeldung für die Fachtagung «20 Jahre SIPT» registriert.</p>

<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="180">Buchungsnummer:</td>
    <td>{{ $registration['booking_number'] }}</td>
  </tr>
  <tr>
    <td width="180">Name:</td>
    <td>{{ $registration['salutation'] }} {{ $registration['title'] }} {{ $registration['firstname'] }} {{ $registration['name'] }}</td>
  </tr>
  <tr>
    <td width="180">E-Mail:</td>
    <td>{{ $registration['email'] }}</td>
  </tr>
  <tr>
    <td width="180">Telefon:</td>
    <td>{{ $registration['phone'] ?? '-' }}</td>
  </tr>
  <tr>
    <td width="180">Adresse:</td>
    <td>{{ $registration['street'] }} {{ $registration['street_no'] }}, {{ $registration['zip'] }} {{ $registration['city'] }}</td>
  </tr>
  <tr>
    <td width="180">Ticket:</td>
    <td>{{ $registration['ticket_type_label'] }}</td>
  </tr>
  <tr>
    <td width="180">Kosten:</td>
    <td>CHF {{ number_format($registration['cost'], 2, '.', "'") }}</td>
  </tr>
  <tr>
    <td width="180">Frühbucher:</td>
    <td>{{ $registration['is_early_bird'] ? 'Ja' : 'Nein' }}</td>
  </tr>
  @if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'friday_only')
  <tr>
    <td width="180">Apéro Freitag:</td>
    <td>{{ $registration['apero_friday'] ? 'Ja' : 'Nein' }}</td>
  </tr>
  @endif
  @if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'saturday_only')
  <tr>
    <td width="180">Mittagessen Samstag:</td>
    <td>{{ $registration['lunch_saturday'] ? 'Ja' : 'Nein' }}</td>
  </tr>
  @endif

</table>

<p>Angemeldet am: {{ \Carbon\Carbon::parse($registration['created_at'])->format('d.m.Y H:i') }}</p>
@endcomponent
