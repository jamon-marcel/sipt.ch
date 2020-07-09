@component('mail::message')
# Bestätigung Abmeldung
<p>Guten Tag {{ $student->fullName }}</p>
<p>Hiermit bestätigen wir die Annulation des Moduls «{{$courseEvent->course->title}}».</p>
<br>
<table class="content-table" cellpadding="0" cellspacing="0">
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
