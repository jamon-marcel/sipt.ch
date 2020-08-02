@component('mail::message')
# Maximale Teilnehmerzahl erreicht
<p>Für das Modul «{{$courseEvent->course->title}}» ist die max. Teilnehmerzahl erreicht. Im Moment sind keine Buchungen für dieses Modul mehr möglich.</p>
<p>Das Modul kann <a href="{{ url('/administration/course/event/edit/'. $courseEvent->id) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a> bearbeitet werden.</p>
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
@endcomponent
