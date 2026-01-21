@include('pdf.partials.header-portrait-invoice')
@include('pdf.partials.css.views.invoice')
<table class="recipient-data">
  <tr>
    <td>
      {{ $invoice['registration']->salutation }} {{ $invoice['registration']->firstname }} {{ $invoice['registration']->name }}<br>
      @if ($invoice['registration']->title) {{ $invoice['registration']->title }}<br> @endif
      {{ $invoice['registration']->street }} {{ $invoice['registration']->street_no }}<br>
      {{ $invoice['registration']->zip }} {{ $invoice['registration']->city }}<br>
    </td>
  </tr>
</table>
<div class="content">
  <h1>Rechnung {{$invoice['invoice_number']}}</h1>
  <table class="invoice-meta-data">
    <tr>
      <td>Datum:</td>
      <td>{{$invoice['invoice_date']}}</td>
    </tr>
    <tr>
      <td>Buchungsnummer:</td>
      <td>{{$invoice['booking_number']}}</td>
    </tr>
  </table>
  <table class="invoice-positions">
    <thead>
      <tr>
        <td class="qty">Menge</td>
        <td class="unit">Einheit</td>
        <td class="description">Bezeichnung</td>
        <td class="price">Preis</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="qty">1</td>
        <td class="unit">Ticket</td>
        <td class="description">
          Fachtagung «20 Jahre SIPT – Soziale Traumata und deren Auswirkungen in der Praxis»<br>
          21./22. August 2026, Alte Kaserne Winterthur<br>
          {{ $invoice['registration']->ticket_type_label }}
        </td>
        <td class="price">CHF {{$invoice['invoice_amount']}}</td>
      </tr>
    </tbody>
  </table>
  <table class="invoice-total">
    <tr>
      <td>Total</td>
      <td>CHF {{$invoice['invoice_amount']}}</td>
    </tr>
  </table>
  <div class="invoice-conditions">
    Kondition: zahlbar innert 30 Tagen<br>Bankverbindung für ausländische Teilnehmer:<br>BIC/SWIFT: ZKBKCHZZ80A, IBAN: CH98 0070 0110 0049 1771 7. Bitte Buchungsnummer vermerken.
  </div>
</div>
@include('pdf.bill.partials.qr-slip')
@include('pdf.partials.footer-portrait')
