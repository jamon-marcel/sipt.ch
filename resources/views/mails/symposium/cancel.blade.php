@component('mail::message')
# Bestätigung Abmeldung / Rechnung {{ $invoiceNumber }}
<p>Guten Tag {{ $symposiumSubscriber->fullName }}</p>
<p>Hiermit bestätigen wir die Annullation der «Jubiläums-Fachtagung — 15 Jahre SIPT».</p>
@if ($penalty == 'partial')
<p>Für Ihre Annullation müssen wir Ihnen leider <strong>CHF 80</strong> Bearbeitungsgebühr in Rechnung stellen. Sämtliche Informationen zu unseren Annullationsbedingungen finden Sie in unseren <a href="{{ route('about_toc') }}">AGB</a>.</p>
@else
<p>Da Ihre Annullation leider nach dem 10.09.2020 erfolgt ist, müssen wir Ihnen leider die Tagungsgebühr von <strong>CHF {{$symposiumSubscriber->cost}}</strong> in Rechnung stellen. Sämtliche Informationen zu unseren Annullationsbedingungen finden Sie in unseren <a href="{{ route('about_toc') }}">AGB</a>.</p>
@endif
<br>
<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120">Rechnung:</td>
    <td>{{ $invoiceNumber }}</td>
  </tr>
  <tr>
    <td width="120">Grund:</td>
    <td>Annullation durch Teilnehmer</td>
  </tr>
  <tr>
    <td width="120">Betrag:</td>
    <td>CHF {{ $invoiceAmount }}</td>
  </tr>
  <tr>
    <td width="120">Modul:</td>
    <td>{{$symposium->title}}</td>
  </tr>
  <tr>
    <td width="120">Datum:</td>
    <td>{{$symposium->date}}</td>
  </tr>
</table>
@include('mails.partials.html.signature')
@endcomponent
