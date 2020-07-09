@component('mail::message')
# Bestätigung Anmeldung
<p>Guten Tag {{ $subscriber['firstname'] }} {{ $subscriber['name'] }}</p>
<p>Vielen Dank für Ihre Anmeldung zur «Jubiläums-Fachtagung — 15 Jahre SIPT». Diese findet wie folgt statt:</p>
<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120">Datum:</td>
    <td>{{ strftime('%A, %d. %B %Y', strtotime($subscriber['symposium']['date']))}}</td>
  </tr>
  <tr>
    <td width="120">Zeit:</td>
    <td>{{ $subscriber['symposium']['timeStart'] }} – {{ $subscriber['symposium']['timeEnd'] }} Uhr</td>
  </tr>
  <tr>
    <td width="120">Ort:</td>
    <td>{{ $subscriber['symposium']['location'] }}</td>
  </tr>
  <tr>
    <td width="120">Kosten:</td>
    <td>{{ $subscriber['symposium']['cost'] }}.–</td>
  </tr>
</table>
<p>Dürfen wir Sie bitten, die Gebühr für die Teilnahme innert 30 Tagen zu überweisen.</p>
<p>Beilage:<br>– Rechnung mit Einzahlungsschein<br>– Lageplan</p>
<br>
@include('mails.partials.html.signature')
@endcomponent
