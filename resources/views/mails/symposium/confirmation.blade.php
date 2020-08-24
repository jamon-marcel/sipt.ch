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
    <td>CHF 200/250 (ehem. und aktuelle AusbildungsteilnehmerInnen/übrige)</td>
  </tr>
</table>
<br>
@include('mails.partials.html.signature')
<br>
<p>Um diese Buchung zu annullieren, klicken Sie bitte <a href="{{ route('symposium_cancel', ['symposiumSubscriber' => $subscriber['id']]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>. Bitte beachten Sie dabei unsere Annullationsbedingungen für die Fachtagung: «Bei Abmeldung bis 10.09.2020 erfolgt Rückerstattung der Tagungsgebühr unter Abzug einer Bearbeitungsgebühr von CHF 80. Nach diesem Termin ist keine Rückerstattung mehr möglich.»</p>
@endcomponent
