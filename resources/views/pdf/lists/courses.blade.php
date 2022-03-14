@include('pdf.partials.header-landscape')
@include('pdf.partials.css.views.course')
@if (isset($opts))
  @if (isset($opts['dateStart']) && $opts['dateStart'] && isset($opts['dateEnd']) && $opts['dateStart'])
  <div class="content-header">
    <h1>Modul-Liste {{date('d.m.Y', strtotime($opts['dateStart']))}} – {{date('d.m.Y', strtotime($opts['dateEnd']))}}</h1>
  </div>
  @elseif (isset($opts['dateStart']) && $opts['dateStart'])
  <div class="content-header">
    <h1>Modul-Liste ab {{date('d.m.Y', strtotime($opts['dateStart']))}}</h1>
  </div>
  @elseif (isset($opts['dateEnd']) && $opts['dateEnd'])
  <div class="content-header">
    <h1>Modul-Liste bis {{date('d.m.Y', strtotime($opts['dateEnd']))}}</h1>
  </div>
  @endif
@else
  <div class="content-header">
    <h1>Modul-Liste ab {{date('d.m.Y', time())}}</h1>
  </div>
@endif
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
        <th>Anm.</th>
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
              <td>{{ isset($d->dates[0]) ? $d->dates[0]->tutor->name : ''}}</td>
              <td>-</td>
            @endif
            <td>{{\AppHelper::timesToString($d->dates)}}</td>
            @if ($d->is_online)
              <td>Online</td>
            @else
              <td>{{\AppHelper::locationName($d->location->id)}}</td>
            @endif
            <td>{{count($d->students)}}</td>
          </tr>
        @endforeach
      </tbody>
    @endif
  </table>
</div>
@include('pdf.partials.footer-landscape')
