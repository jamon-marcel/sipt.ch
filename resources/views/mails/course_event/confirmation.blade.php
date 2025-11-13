@component('mail::message')
# Bestätigung Anmeldung
<p>Guten Tag {{ $student->fullName }}</p>
<p>Vielen Dank für Ihre Anmeldung zum Modul «{{$courseEvent->course->title}}». Das Modul findet wie folgt statt:</p>
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
  <tr>
    <td width="120">Kosten:</td>
    <td>CHF {{ $courseEvent->course->cost }}</td>
  </tr>
</table>
<br>
<p>Die Rechnung wird Ihnen rund 30 Tage vor Kursbeginn zugestellt, die endgültige Einladung etwa 10 Tage vor Kursstart.</p>
<p>Falls Sie die Buchung stornieren möchten, klicken Sie bitte <a href="{{ route('booking_cancel_preview', ['courseEvent' => $courseEvent->id, 'student' => $student->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</p>
<p>Möchten Sie weitere Module besuchen? Verwalten Sie Ihre Buchungen und persönlichen Daten bequem unter: <a href="{{ url('/student') }}" class="anchor" style="color: #ff7a00; text-decoration: none;">{{ url('/student') }}</a></p>
@include('mails.partials.html.signature')
@endcomponent