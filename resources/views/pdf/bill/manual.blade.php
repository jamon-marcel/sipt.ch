@include('pdf.partials.header-portrait-invoice')
@include('pdf.partials.css.views.invoice')
<table class="recipient-data">
  <tr>
    @if ($invoice['client_type'] == 'other')
      <td>
        {!! nl2br($invoice['client']) !!}
      </td>
    @elseif($invoice['client_type'] == 'tutor')
      <td>
        {{ $invoice['client']->fullName}}<br>
        @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
        {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
        {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
      </td>
    @elseif($invoice['client_type'] == 'student')
      @if ($invoice['client']->has_alt_address)
        <td>
          {{ $invoice['client']->alt_company}}<br>
          @if ($invoice['client']->alt_name) {{ $invoice['client']->alt_name}}<br> @endif
          {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
          {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
        </td>
        <td>
          Kursteilnehmer:<br>
          {{ $invoice['client']->fullName}}<br>
          @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
          {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
          {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
        </td>
      @else
        <td>
          {{ $invoice['client']->fullName}}<br>
          @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
          {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
          {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
        </td>
      @endif
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
      <td>Kunden-Nr.:</td>
      <td>{{$invoice['client_number'] ?? '-'}}</td>
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
      <td class="number">–</td>
      <td class="description">
        {{$invoice['description']}}
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

    @if ($invoice['client_type'] == 'other')
      {!! nl2br($invoice['client']) !!}
    @elseif($invoice['client_type'] == 'tutor')
      {{ $invoice['client']->fullName}}<br>
      {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
      {{ $invoice['client']->zip}} {{ $invoice['client']->city}}
    @elseif($invoice['client_type'] == 'student')
      @if ($invoice['client']->has_alt_address)
        {{ $invoice['client']->alt_company}}<br>
        {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
        {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
      @else
        {{ $invoice['client']->fullName}}<br>
        {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
        {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
      @endif   
    @endif

  </span>
  <span class="payment-item payment-address-right">
    @if ($invoice['client_type'] == 'other')
      {!! nl2br($invoice['client']) !!}
    @elseif($invoice['client_type'] == 'tutor')
      {{ $invoice['client']->fullName}}<br>
      {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
      {{ $invoice['client']->zip}} {{ $invoice['client']->city}}
    @elseif($invoice['client_type'] == 'student')
      @if ($invoice['client']->has_alt_address)
        {{ $invoice['client']->alt_company}}<br>
        {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
        {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
      @else
        {{ $invoice['client']->fullName}}<br>
        {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
        {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
      @endif   
    @endif
  </span>
  <span class="payment-item payment-codeline">{{$payment_slip['esr_codeline_str']}}</span>
  <img src="{{ asset('/assets/img/einzahlungsschein.jpg') }}" width="100">
</div>
{{-- @include('pdf.bill.partials.qr-slip') --}}
@include('pdf.partials.footer-portrait')
