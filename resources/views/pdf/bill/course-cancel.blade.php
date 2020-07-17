@include('pdf.partials.header-portrait-invoice')
@include('pdf.partials.css.views.invoice')
<table class="recipient-data">
  <tr>
    @if ($invoice['student']->has_alt_address)
      <td>
        {{ $invoice['student']->alt_company}}<br>
        {{ $invoice['student']->alt_name}}<br>
        {{ $invoice['student']->alt_street}} {{ $invoice['student']->alt_street_no}}<br>
        {{ $invoice['student']->alt_zip}} {{ $invoice['student']->alt_city}}
      </td>
      <td>
        Kursteilnehmer:<br>
        @if ($invoice['student'])
          {{ $invoice['student']->title}}<br>
        @endif
        {{ $invoice['student']->fullName}}<br>
        {{ $invoice['student']->street}} {{ $invoice['student']->street_no}}<br>
        {{ $invoice['student']->zip}} {{ $invoice['student']->city}}<br>
      </td>
    @else
      <td>
        @if ($invoice['student']->title)
          {{ $invoice['student']->title}}<br>
        @endif
        {{ $invoice['student']->fullName}}<br>
        {{ $invoice['student']->street}} {{ $invoice['student']->street_no}}<br>
        {{ $invoice['student']->zip}} {{ $invoice['student']->city}}<br>
      </td>
    @endif
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
      <td class="unit">Modul</td>
      <td class="number">{{$invoice['courseEvent']->courseNumber}}</td>
      <td class="description">
        {{$invoice['courseEvent']->course->title }}, {{\AppHelper::datesToString($invoice['courseEvent']->dates)}}
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
    @if ($invoice['student']->has_alt_address)
      {{ $invoice['student']->alt_company}}<br>
      {{ $invoice['student']->alt_street}} {{ $invoice['student']->alt_street_no}}<br>
      {{ $invoice['student']->alt_zip}} {{ $invoice['student']->alt_city}}
    @else
      {{ $invoice['student']->fullName}}<br>
      {{ $invoice['student']->street}} {{ $invoice['student']->street_no}}<br>
      {{ $invoice['student']->zip}} {{ $invoice['student']->city}}<br>
    @endif
  </span>
  <span class="payment-item payment-address-right">
    @if ($invoice['student']->has_alt_address)
      {{ $invoice['student']->alt_company}}<br>
      {{ $invoice['student']->alt_street}} {{ $invoice['student']->alt_street_no}}<br>
      {{ $invoice['student']->alt_zip}} {{ $invoice['student']->alt_city}}
    @else
      {{ $invoice['student']->fullName}}<br>
      {{ $invoice['student']->street}} {{ $invoice['student']->street_no}}<br>
      {{ $invoice['student']->zip}} {{ $invoice['student']->city}}<br>
    @endif
  </span>
  <span class="payment-item payment-codeline">{{$payment_slip['esr_codeline_str']}}</span>
  <img src="{{ asset('/assets/img/einzahlungsschein.jpg') }}" width="100">
</div>
@include('pdf.partials.footer-portrait')
