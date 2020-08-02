@include('pdf.partials.header-landscape')
@include('pdf.partials.css.views.participants')
<div class="content-header">
  <h1>TeilnehmerInnen-Liste</h1>
  <h2>
    {{$data->courseNumber}}, {{$data->course->title}}<br>{{\AppHelper::datesToString($data->dates)}}, {{\AppHelper::tutorsToString($data->dates)}}
  </h2>
</div>
<div class="content">
  @if ($data->students)
    <table class="list list-participants" cellspacing="0" cellpadding="0">
      @foreach($data->students as $student)
        <tr>
          <td>{{$student->number}}</td>
          <td>{{$student->fullName}}</td>
          <td>{{$student->city}}</td>
          <td>{{$student->user->email}}</td>
          <td>{{$student->qualifications}}</td>
          <td>{{$student->pivot->booking_number}}</td>
          <td style="text-align: right">{{date('d.m.Y', strtotime($student->pivot->created_at))}}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="7" style="width: 100%">Anzahl TeilnehmerInnen: {{count($data->students)}}</td>
      </tr>
    </table>
  @endif
</div>
@include('pdf.partials.footer-landscape')
