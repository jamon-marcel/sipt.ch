@include('pdf.partials.header-portrait-invoice')
@include('pdf.partials.css.views.invoice')
<table class="recipient-data">
  <tr>
    <td>
      @if ($invoice['symposiumSubscriber']->title)
        {{ $invoice['symposiumSubscriber']->title}}<br>
      @endif
      {{ $invoice['symposiumSubscriber']->fullName}}<br>
      {{ $invoice['symposiumSubscriber']->street}} {{ $invoice['symposiumSubscriber']->street_no}}<br>
      {{ $invoice['symposiumSubscriber']->zip}} {{ $invoice['symposiumSubscriber']->city}}<br>
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
      <td>Grund:</td>
      <td>Annullation durch Teilnehmer</td>
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
        {{ $invoice['symposium']->title }}<br>{!! $invoice['symposium']->description !!}
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
<div class="payment-slip">
  <span class="payment-item payment-item__reference">{{$payment_slip['esr_reference_str']}}</span>
  <span class="payment-item payment-item__reference-small">{{$payment_slip['esr_reference_str']}}</span>
  <span class="payment-item payment-item__amount-left">{{$payment_slip['invoice_amount_arr'][0]}}</span>
  <span class="payment-item payment-item__amount-left-cents">{{$payment_slip['invoice_amount_arr'][1]}}</span>
  <span class="payment-item payment-item__amount-right">{{$payment_slip['invoice_amount_arr'][0]}}</span>
  <span class="payment-item payment-item__amount-right-cents">{{$payment_slip['invoice_amount_arr'][1]}}</span>
  <span class="payment-item payment-address-left">
    {{ $invoice['symposiumSubscriber']->fullName}}<br>
    {{ $invoice['symposiumSubscriber']->street}} {{ $invoice['symposiumSubscriber']->street_no}}<br>
    {{ $invoice['symposiumSubscriber']->zip}} {{ $invoice['symposiumSubscriber']->city}}<br>
  </span>
  <span class="payment-item payment-address-right">
    {{ $invoice['symposiumSubscriber']->fullName}}<br>
    {{ $invoice['symposiumSubscriber']->street}} {{ $invoice['symposiumSubscriber']->street_no}}<br>
    {{ $invoice['symposiumSubscriber']->zip}} {{ $invoice['symposiumSubscriber']->city}}<br>
  </span>
  <span class="payment-item payment-codeline">{{$payment_slip['esr_codeline_str']}}</span>
  <img src="{{ asset('/assets/img/einzahlungsschein.jpg') }}" width="100">
</div>
@include('pdf.partials.footer-portrait')
