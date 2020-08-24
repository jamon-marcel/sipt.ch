@component('mail::message')
# Rechnung {{ $invoiceNumber }}
<p>Guten Tag {{ $subscriber->fullName }}</p>
<p>In der Beilage erhalten Sie unsere Rechnung für die Fachtagung «{{$symposium->title}}».</p>
<br>
<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120">Rechnung:</td>
    <td>{{ $invoiceNumber }}</td>
  </tr>
  <tr>
    <td width="120">Betrag:</td>
    <td>CHF {{ $invoiceAmount }}</td>
  </tr>
  <tr>
    <td width="120">Modul:</td>
    <td>{{ $symposium->title }}</td>
  </tr>
  <tr>
    <td width="120">Datum:</td>
    <td>10. Oktober 2020</td>
  </tr>
</table>
@include('mails.partials.html.signature')
@endcomponent
