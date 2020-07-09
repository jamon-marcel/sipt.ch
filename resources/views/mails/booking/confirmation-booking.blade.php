@component('mail::message')
# Bestätigung Anmeldung
<p>Guten Tag {{ $student->fullName }}</p>
<p>Vielen Dank für Ihre Anmeldung für das Modul «{{$courseEvent->course->title}}». Dieses findet wie folgt statt:</p>
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
    <td>CHF {{ $courseEvent->course->cost }}.–</td>
  </tr>
</table>
<br>
<p>Die Rechnung sowie die definitive Einladung für das Modul erhalten Sie in den nächsten Tagen.</p>
<p>Um diese Buchung zu annulieren, klicken Sie bitte <a href="{{ route('booking_cancel_preview', ['courseEvent' => $courseEvent->id, 'student' => $student->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</p>
<p>Möchten Sie weitere Module besuchen? Verwalten Sie ihre Module sowie Ihre persönlichen Daten einfach und bequem unter: <a href="{{ url('/student') }}" class="anchor" style="color: #ff7a00; text-decoration: none;">{{ url('/student') }}</a></p>
@include('mails.partials.html.signature')
@endcomponent
