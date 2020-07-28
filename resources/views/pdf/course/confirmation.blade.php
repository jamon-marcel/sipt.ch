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
  <h1>Kursbestätigung<br>für {{$student->fullName}}</h1>
  <p>Winterthur, {{date('d.m.Y', time())}}</p>
  <p> {{$student->fullName}} absolvierte an untenstehenden Daten erfolgreich das aufgeführte Modul:</p>
  <table class="list">
    <tr>
      <td style="width: 25mm">Modul:</td>
      <td>{{$courseEvent->course->title}}</td>
    </tr>
    @if ($courseEvent->dates)
      @for ($i = 0; $i < count($courseEvent->dates); $i++)
        <tr>
          <td>{{$i+1}}. Kurstag:</td>
          <td>{{date('d.m.Y', strtotime($courseEvent->dates[$i]->date))}}</td>
        </tr>
        <tr>
          <td>Dozent/in:</td>
          <td>{{$courseEvent->dates[$i]->tutor->fullName}}</td>
        </tr>
      @endfor
    @endif
    <tr>
      <td>Credits:</td>
      <td>{{$courseEvent->course->credits}}</td>
    </tr>
    <tr>
      <td>Kursdauer:</td>
      <td>{{$courseEvent->course->durability}} Stunden à 60 Minuten</td>
    </tr>
    <tr>
      <td>Kursgebühr:</td>
      <td>CHF {{$courseEvent->course->cost}}</td>
    </tr>
  </table>
  <p>Die Veranstaltungen des Schweizer Instituts für Psychotraumatologie sind anerkannt als<br>Fortbildung SGPP (1h Fortbildung entspricht 1 Credit).</p>
  <p style="margin-bottom: 5mm">PD Dr. phil. Rosmarie Barwinski<br>Leitung SIPT GmbH</p>
  <img src="{{ asset('/assets/img/signatur-barwinski.jpg') }}" width="100" class="signature">
</div>
@include('pdf.partials.footer-portrait')
