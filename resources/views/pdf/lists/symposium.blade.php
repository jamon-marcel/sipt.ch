@include('pdf.partials.header-landscape')
@include('pdf.partials.css.views.participants')
<div class="content-header">
  <h1>TeilnehmerInnen-Liste</h1>
  <h2>
    100.101020 – Jubiläums-Fachtagung — 15 Jahre SIPT<br>Samstag, 10. Oktober 2020
  </h2>
</div>
<div class="content">
  @if ($subscribers)
    <table class="list list-symposium-participants" cellspacing="0" cellpadding="0">
      @foreach($subscribers as $subscriber)
        <tr>
          <td>{{$subscriber->number}}</td>
          <td>{{$subscriber->fullName}}</td>
          <td>{{$subscriber->city}}</td>
          <td>{{$subscriber->email}}</td>
          <td>{{$subscriber->title}}</td>
          <td>{{$subscriber->booking_number}}</td>
          <td>
            @if ($subscriber->invoice) 
              @if ($subscriber->invoice->is_paid == 1)
                bez.
              @else
                –
              @endif
            @endif
          </td>
          <td>{{\MoneyFormatHelper::number($subscriber->cost)}}</td>
          <td style="text-align: right">{{date('d.m.Y', strtotime($subscriber->created_at))}}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="9" style="width: 100%">Anzahl TeilnehmerInnen: {{count($subscribers)}}</td>
      </tr>
    </table>
  @endif
</div>
@include('pdf.partials.footer-landscape')
