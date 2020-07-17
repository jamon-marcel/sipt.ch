@component('mail::message')
# Bestätigung Abmeldung / Rechnung {{ $invoiceNumber }}
<p>Guten Tag {{ $student->fullName }}</p>
<p>Hiermit bestätigen wir die Annullation des Moduls «{{$courseEvent->course->title}}».</p>
<p>Für Ihre Annullation müssen wir Ihnen leider {{$penalty}}% der Modulkosten in Rechnung stellen. Sämtliche Informationen zu unseren Annullationsbedingungen finden Sie in unseren <a href="{{ route('about_toc') }}">AGB</a>.</p>
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
    <td>{{ $courseEvent->course->title }}</td>
  </tr>
  <tr>
    <td width="120">Datum:</td>
    <td>{{ AppHelper::datesToString($courseEvent->dates) }}</td>
  </tr>
</table>
<br>
<p>Möchten Sie weitere Module besuchen? Verwalten Sie ihre Module sowie Ihre persönlichen Daten einfach und bequem unter: <a href="{{ url('/student') }}" class="anchor" style="color: #ff7a00; text-decoration: none;">{{ url('/student') }}</a></p>
@include('mails.partials.html.signature')
@endcomponent
