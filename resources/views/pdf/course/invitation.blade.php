@include('pdf.partials.header-portrait')
@include('pdf.partials.css.views.confirmation')
<table class="recipient-data">
  <tr>
    <td>
      {{$student->fullName}}<br>
      {{$student->street}} {{$student->street_no}}<br>
      {{$student->zip}} {{$student->city}}<br>
    </td>
  </tr>
</table>
<div class="content">
  <h1>Kurseinladung</h1>
  <p>Winterthur, {{date('d.m.Y', time())}}</p>
  <p>Guten Tag {{$student->fullName}}<br><br>Das Modul «{{$courseEvent->course->title}}» findet wie folgt statt:</p>
  <table class="list">
    <tr>
      <td style="width: 25mm">Modul:</td>
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
    <tr>
      <td>Ort:</td>
      <td>{{AppHelper::locationNameFull($courseEvent->location_id, TRUE)}}</td>
    </tr>
    <tr>
      <td>Kursgebühr:</td>
      <td>CHF {{$courseEvent->course->cost}}</td>
    </tr>
  </table>
  <p style="margin-bottom: 5mm">Freundliche Grüsse<br>PD Dr. phil. Rosmarie Barwinski<br>Leitung SIPT GmbH</p>
  <img src="{{ asset('/assets/img/signatur-barwinski.jpg') }}" width="100" class="signature">
</div>
@include('pdf.partials.footer-portrait')
