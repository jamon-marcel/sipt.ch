@include('pdf.partials.header')
<div class="content">
  <table class="recipient-data">
    <tr>
      <td>
        {{$subscriber->firstname}} {{$subscriber->name}}<br>
        {{$subscriber->street}} {{$subscriber->street_no}}<br>
        {{$subscriber->zip}} {{$subscriber->city}}
      </td>
      <td>
      </td>
    </tr>
  </table>
  <h1>Rechnung</h1>
  <table class="invoice-meta-data">
    <tr>
      <td>Datum:</td>
      <td>{{date('d.m.Y', time())}}</td>
    </tr>
    <tr>
      <td>Kunden-Nr.:</td>
      <td>–</td>
    </tr>
    <tr>
      <td>Kursreservation:</td>
      <td>–</td>
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
      <td class="number">–</td>
      <td class="description">
        {{ $subscriber->symposium->title }}<br>{!! $subscriber->symposium->description !!}
      </td>
      <td class="price"></td>
    </tbody>
  </table>
  <table class="invoice-total">
    <tr>
      <td>Total</td>
      <td>CHF {!! AppHelper::number($subscriber->symposium->cost) !!}</td>
    </tr>
  </table>
  <div class="invoice-conditions">
    Kondition: zahlbar vor Kursbeginn<br>Bankverbindung für ausländische Teilnehmer:<br>BIC/SWIFT: ZKBKCHZZ80A, IBAN: CH98 0070 0110 0049 1771 7. Bitte Kursnummer vermerken.
  </div>
</div>
@include('pdf.partials.footer')
