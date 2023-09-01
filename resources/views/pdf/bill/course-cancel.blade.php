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
    <tr>
      <td class="qty">Menge</td>
      <td class="unit">Einheit</td>
      <td class="number">Kurs-Nr.</td>
      <td class="description">Bezeichnung</td>
      <td class="price">Preis</td>
    </tr>
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
@include('pdf.bill.partials.qr-slip')
@include('pdf.partials.footer-portrait')
