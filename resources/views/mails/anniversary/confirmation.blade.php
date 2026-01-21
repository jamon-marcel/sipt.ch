@component('mail::message')
# Bestätigung Anmeldung

<p>Guten Tag {{ $registration['salutation'] }} {{ $registration['firstname'] }} {{ $registration['name'] }}</p>

<p>Vielen Dank für Ihre Anmeldung zur Fachtagung «20 Jahre SIPT – Soziale Traumata und deren Auswirkungen in der Praxis».</p>

<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="180">Datum:</td>
    <td>Freitag, 21. und Samstag, 22. August 2026</td>
  </tr>
  <tr>
    <td width="180">Ort:</td>
    <td>Alte Kaserne, Technikumstrasse 8, 8403 Winterthur</td>
  </tr>
  <tr>
    <td width="180">Ihre Buchung:</td>
    <td>{{ $registration['ticket_type_label'] }}</td>
  </tr>
  <tr>
    <td width="180">Kosten:</td>
    <td>CHF {{ number_format($registration['cost'], 2, '.', "'") }}</td>
  </tr>
  @if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'friday_only')
  <tr>
    <td width="180">Apéro Freitag:</td>
    <td>{{ $registration['apero_friday'] ? 'Ja, ich nehme teil' : 'Nein, ich nehme nicht teil' }}</td>
  </tr>
  @endif
  @if($registration['ticket_type'] === 'both_days' || $registration['ticket_type'] === 'saturday_only')
  <tr>
    <td width="180">Mittagessen Samstag:</td>
    <td>{{ $registration['lunch_saturday'] ? 'Ja, ich nehme teil' : 'Nein, ich nehme nicht teil' }}</td>
  </tr>
  @endif
</table>

<p>Anbei erhalten Sie Ihre Rechnung.</p>

<br>
@include('mails.partials.html.signature')
@endcomponent
