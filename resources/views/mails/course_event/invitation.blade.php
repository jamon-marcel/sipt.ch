@component('mail::message')
# Kurseinladung Modul «{{$courseEvent->course->title}}»
<p>Guten Tag {{ $student->fullName }}</p>
<p>Das Modul «{{$courseEvent->course->title}}» findet wie folgt statt:</p>
<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120">Modul:</td>
    <td>{{$courseEvent->course->title}}</td>
  </tr>
  @if ($courseEvent->dates)
    @for ($i = 0; $i < count($courseEvent->dates); $i++)
      <tr>
        <td>{{$i+1}}. Kurstag:</td>
        <td>{{date('d.m.Y', strtotime($courseEvent->dates[$i]->date))}}, {{$courseEvent->dates[$i]->timeStart}} – {{$courseEvent->dates[$i]->timeEnd}} Uhr</td>
      </tr>
      <tr>
        <td>Dozent/in:</td>
        <td>{{$courseEvent->dates[$i]->tutor->fullName}}</td>
      </tr>
    @endfor
  @endif
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
  <tr>
    <td>Kursgebühr:</td>
    <td>CHF {{$courseEvent->course->cost}}</td>
  </tr>
</table>
@include('mails.partials.html.signature')
<div>
  Beilagen:<br>
  – Kurseinladung<br>
  – Kursbeurteilung<br>
  @if ($hasMap)
  – Lageplan
  @endif
</div>
@endcomponent
