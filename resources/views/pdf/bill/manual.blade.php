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
      <tr>
        <td class="qty">Menge</td>
        <td class="unit">Einheit</td>
        <td class="number">Kurs-Nr.</td>
        <td class="description">Bezeichnung</td>
        <td class="price">Preis</td>
      </tr>
    <tbody>
      <tr>
        <td class="qty">1</td>
        <td class="unit">Modul</td>
        <td class="number">–</td>
        <td class="description">
          {{$invoice['description']}}
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
    Kondition: zahlbar vor Kursbeginn<br>Bankverbindung für ausländische Teilnehmer:<br>BIC/SWIFT: ZKBKCHZZ80A, IBAN: CH98 0070 0110 0049 1771 7. Bitte Kursnummer vermerken.
  </div>
</div>
@include('pdf.bill.partials.qr-slip')
@include('pdf.partials.footer-portrait')
