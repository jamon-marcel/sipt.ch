@include('pdf.partials.header-portrait-invoice')
@include('pdf.partials.css.views.invoice')
<table class="recipient-data">
  <tr>
    <td>
      {{ $invoice['client']->fullName}}<br>
      @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
      {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
      {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
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
      <td>Kunden-Nr.:</td>
      <td>{{$invoice['client_number']}}</td>
    </tr>
    <tr>
      <td>Kursreservation:</td>
      <td>{{$invoice['booking_number']}}</td>
    </tr>
  </table>
  <table class="invoice-positions">
    <thead>
      <tr>
        <td class="qty">Menge</td>
        <td class="unit">Einheit</td>
        <td class="number">Kurs-Nr.</td>
        <td class="description">Bezeichnung</td>
        <td class="price">Preis</td>
      </tr>
    <thead>
    <tbody>
      <td class="qty">1</td>
      <td class="unit">Fachtagung</td>
      <td class="number">100.101020</td>
      <td class="description">
        {{$invoice['symposium']->title }}<br>{!! $invoice['symposium']->description !!}
      </td>
      <td class="price">CHF {{$invoice['invoice_amount']}}</td>
    </tbody>
  </table>
  <table class="invoice-total">
    <tr>
      <td>Total</td>
      <td>CHF {{$invoice['invoice_amount']}}</td>
    </tr>
  </table>
  <div class="invoice-conditions">
    Kondition: zahlbar vor Kursbeginn<br>Bankverbindung für ausländische Teilnehmer:<br>BIC/SWIFT: ZKBKCHZZ80A, IBAN: CH98 0070 0110 0049 1771 7. Bitte Kursnummer vermerken.
  </div>
</div>
@include('pdf.bill.partials.qr-slip')
@include('pdf.partials.footer-portrait')
