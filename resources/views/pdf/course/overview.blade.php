@include('pdf.partials.header-portrait')
@include('pdf.partials.css.views.overview')
<div class="content">
  <h1>Kursübersicht</h1>
  <table class="student">
    <tr>
      <td>KursteilnehmerIn:</td>
      <td>{{$student->fullName}}</td>
    </tr>
    <tr>
      <td>Adresse:</td>
      <td>
        {{$student->street}}
        @if ($student->street_no) {{$student->street_no}}, @else, @endif
        {{$student->zip}} {{$student->city}}
      </td>
    </tr>
    <tr>
      <td>E-Mail</td>
      <td>{{$student->user->email}}</td>
    </tr>
    @if ($student->phone)
      <tr>
        <td>Tel. P:</td>
        <td>{{$student->phone}}</td>
      </tr>
    @endif
    @if ($student->phone_business)
      <tr>
        <td>Tel. G:</td>
        <td>{{$student->phone_business}}</td>
      </tr>
    @endif
    @if ($student->mobile)
      <tr>
        <td>Mobile:</td>
        <td>{{$student->mobile}}</td>
      </tr>
    @endif
    @if ($student->qualifications)
      <tr>
        <td>Beruf:</td>
        <td>{{$student->qualifications}}</td>
      </tr>
    @endif
    @if ($student->number)
      <tr>
        <td>Kunden-Nr.:</td>
        <td>{{$student->number}}</td>
      </tr>
    @endif
  </table>
  <table class="course-list" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <td>Modul</td>
        <td>Titel</td>
        <td>Datum</td>
        <td>Kurs-Nr.</td>
        <td style="text-align:right">Status</td>
      </tr>
    </thead>
    <tbody>
      @foreach($courseEvents as $courseEvent)
        <tr>
          <td>
            {{$courseEvent->course->number}}
          </td>
          <td style="width: 86mm; padding-right: 2mm">{{ Str::limit($courseEvent->course->title, 50) }}</td>
          <td>{{ AppHelper::datesToString($courseEvent->dates) }}</td>
          <td>{{$courseEvent->courseNumber}}</td>
          <td style="text-align:right">
            @if ($courseEvent->pivot->has_attendance)
              besucht
            @else
              angemeldet
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('pdf.partials.footer-portrait')
