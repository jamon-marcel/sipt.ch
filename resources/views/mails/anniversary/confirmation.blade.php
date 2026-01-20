@component('mail::message')
# Bestätigung Anmeldung

<p>Guten Tag {{ $registration['salutation'] }} {{ $registration['firstname'] }} {{ $registration['name'] }}</p>

<p>Vielen Dank für Ihre Anmeldung zur Fachtagung «20 Jahre SIPT – Soziale Traumata und deren Auswirkungen in der Praxis».</p>

<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="150">Datum:</td>
    <td>Freitag, 21. und Samstag, 22. August 2026</td>
  </tr>
  <tr>
    <td width="150">Ort:</td>
    <td>Alte Kaserne, Technikumstrasse 8, 8403 Winterthur</td>
  </tr>
  <tr>
    <td width="150">Ihre Buchung:</td>
    <td>{{ $registration['ticket_type_label'] }}</td>
  </tr>
  <tr>
    <td width="150">Kosten:</td>
    <td>CHF {{ number_format($registration['cost'], 2, '.', "'") }}</td>
  </tr>
</table>

@if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'friday_only')
<p><strong>Apéro am Freitag, 21.8.26:</strong> {{ $registration['apero_friday'] ? 'Ja, ich nehme teil' : 'Nein, ich nehme nicht teil' }}</p>
@endif

@if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'saturday_only')
<p><strong>Mittagessen am Samstag, 22.8.26:</strong> {{ $registration['lunch_saturday'] ? 'Ja, ich nehme teil' : 'Nein, ich nehme nicht teil' }}</p>
@endif

<p>Sie erhalten in Kürze eine Rechnung per E-Mail.</p>

<br>
@include('mails.partials.html.signature')
@endcomponent
