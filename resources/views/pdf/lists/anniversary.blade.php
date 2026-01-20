@include('pdf.partials.header-landscape')
@include('pdf.partials.css.views.participants')
<div class="content-header">
  <h1>TeilnehmerInnen-Liste</h1>
  <h2>
    20 Jahre SIPT – Fachtagung<br>Freitag, 21. und Samstag, 22. August 2026
  </h2>
</div>
<div class="content">
  @if ($registrations)
    <table class="list list-symposium-participants" cellspacing="0" cellpadding="0">
      <tr style="font-weight: bold; border-bottom: 1px solid #000;">
        <td>Name</td>
        <td>Ort</td>
        <td>E-Mail</td>
        <td>Ticket</td>
        <td>Buchung</td>
        <td>Bez.</td>
        <td>Betrag</td>
        <td style="text-align: right">Datum</td>
      </tr>
      @foreach($registrations as $registration)
        <tr>
          <td>{{$registration->fullName}}</td>
          <td>{{$registration->city}}</td>
          <td>{{$registration->email}}</td>
          <td>{{$registration->ticketTypeLabel}}</td>
          <td>{{$registration->booking_number}}</td>
          <td>
            @if ($registration->invoice)
              @if ($registration->invoice->is_paid == 1)
                bez.
              @else
                –
              @endif
            @else
              –
            @endif
          </td>
          <td>{{\MoneyFormatHelper::number($registration->cost)}}</td>
          <td style="text-align: right">{{date('d.m.Y', strtotime($registration->created_at))}}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="8" style="width: 100%">Anzahl TeilnehmerInnen: {{count($registrations)}}</td>
      </tr>
    </table>
  @endif
</div>
@include('pdf.partials.footer-landscape')
