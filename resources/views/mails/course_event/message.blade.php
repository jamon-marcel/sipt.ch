@component('mail::message')
<p>{{$message->senderName}} ({{$message->senderEmail}}) hat folgende Nachricht gesendet:</p>
<h1>{{$message->subject}}</h1>
{!! $message->message !!}
<br><br>
<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120">Modul:</td>
    <td>{{ $courseEvent->course->title }}</td>
  </tr>
  <tr>
    <td>Datum:</td>
    <td>{{ AppHelper::datesToString($courseEvent->dates) }}</td>
  </tr>
  @if ($courseEvent->is_online)
    <tr>
      <td>Ort:</td>
      <td>Kurs findet Online statt</td>
    </tr>
  @else
    <tr>
      <td>Ort:</td>
      <td>{{AppHelper::locationNameFull($courseEvent->location_id, TRUE)}}</td>
    </tr>
    <tr>
      <td>Lageplan:</td>
      <td><a href="{{AppHelper::locationMap($courseEvent->location_id)}}" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">Googlemaps</a></td>
    </tr>
  @endif
</table>
<p>Alle Informationen zu diesem Modul finden Sie <a href="@if ($recipient->student_id){{ url('/student/course/event/' . $courseEvent->id)}}@else{{ url('/administration/course/event/show/' . $courseEvent->id)}}@endif" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</p>
<p>SIPT Schweizer Institut für Psychotraumatologie</p>
@endcomponent