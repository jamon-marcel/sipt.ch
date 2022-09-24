@include('pdf.partials.header-landscape')
@include('pdf.partials.css.views.course')
<div class="content-header" style="top: -43mm">
  <h1>{{ $data_title }}<br><div style="margin-top: 1mm">Modul-Liste ab {{date('d.m.Y', time())}}</div></h1>
</div>
<div class="content">
  <table class="list list-courses" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th>Tag 1</th>
        <th>Tag 2</th>
        <th>Modul-Nr.</th>
        <th>Modul-Bezeichnung</th>
        <th>DozentIn 1</th>
        <th>DozentIn 2</th>
        <th>Zeiten</th>
        <th>Ort</th>
      </tr>
    </thead>
    @if ($data)
      <tbody>
        @foreach($data as $d)
          <tr>
            @if (count($d->dates) == 2)
              @foreach($d->dates as $date)
                <td>{{date('d.m.y', strtotime($date->date))}}</td>
              @endforeach
            @else
              <td>{{ isset($d->dates[0]) ? date('d.m.y', strtotime($d->dates[0]->date)) : ''}}</td>
              <td>-</td>
            @endif
            <td>{{$d->courseNumber}}</td>
            <td>{{$d->course->title}}</td>
            @if (count($d->dates) == 2)
              @foreach($d->dates as $date)
                @if ($date->tutor)
                  <td>{{$date->tutor->name}}</td>
                @endif
              @endforeach
            @else
              <td>{{ isset($d->dates[0]) && isset($d->dates[0]->tutor) ? $d->dates[0]->tutor->name : ''}}</td>
              <td>-</td>
            @endif
            <td>{{\AppHelper::timesToString($d->dates)}}</td>
            @if ($d->is_online)
              <td>Online</td>
            @else
              <td>{{\AppHelper::locationName($d->location->id)}}</td>
            @endif
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
</div>
@include('pdf.partials.footer-landscape')
