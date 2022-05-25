<style>
  .qr {
    border-top: .15mm dashed #222;
    bottom: 10mm;
    left: 0;
    font-weight: 400;
    color: #000000;
    height: 105mm;
    position: absolute;
    width: 210mm;
    left: -20mm;
  }
  
  .qr * {
    font-family: Arial, Helvetica, sans-serif !important;
  }

  .qr h1, 
  .qr h2,
  .qr p {
    margin: 0 !important;
  }
  
  .qr-item {
    float: left;
    height: 95mm;
    padding: 5mm;
  }
  
  .qr-item.qr-item--receipt {
    height: 95mm;
    width: 52mm;
  }
  
  .qr-item.qr-item--payment {
    height: 95mm;
    width: 138mm;
  }
  
  .qr-item h1 {
    font-size: 11pt;
    font-weight: 700;
    height: 7mm;
  }
  
  .qr-item.qr-item--receipt h2 {
    font-size: 6pt;
    font-weight: 700;
    line-height: 9pt;
  }
  
  .qr-item.qr-item--receipt p {
    font-size: 8pt;
    font-weight: 400;
    line-height: 9pt;
    margin-bottom: 9pt;
  }
  
  .qr-item--receipt__information {
    height: 63mm;
  }
  
  .qr-item--receipt__information > div {
    margin-bottom: 9pt;
  }
  
  .qr-item--receipt__amount {
    height: 14mm;
    vertical-align: top;
  }
  
  .qr-item--receipt__amount .currency {
    display: inline-block;
    vertical-align: top;
    width: 12mm;
  }
  
  .qr-item--receipt__amount .amount {
    display: inline-block;
    vertical-align: top;
    width: 40mm;
  }
  
  .qr-item--receipt__acceptance {
    font-size: 6pt;
    font-weight: 700 !important;
    line-height: 8pt;
    text-align: right;
  }
  
  .qr-item--payment__left {
    float: left;
    width: 51mm;
  }
  
  .qr-item--payment__right {
    float: right;
    width: 87mm;
  }
  
  .qr-item--payment h1 {
    margin-bottom: 5mm;
  }
  
  .qr-item--payment__code {
    height: 46mm;
    width: 46mm;
  }
  
  .qr-item--payment__code img {
    display: block;
    height: 46mm; 
    width: 46mm; 
  }
  
  .qr-item--payment__amount {
    margin-top: 7.4mm;
  }
  
  .qr-item--payment__amount .currency {
    display: inline-block;
    vertical-align: top;
    width: 16mm;
  }
  
  .qr-item--payment__amount .amount {
    display: inline-block;
    vertical-align: top;
    width: 30mm;
  }
  
  .qr-item--payment__amount h2 {
    font-size: 8pt;
    line-height: 11pt;
    font-weight: bold;
  }
  
  .qr-item--payment__amount p {
    font-size: 10pt;
    line-height: 13pt;
  }
  
  .qr-item--payment__info > div {
    margin-bottom: 9pt;
  }
  
  .qr-item--payment__info h2 {
    font-weight: bold;
    font-size: 8pt;
    line-height: 11pt;
  }
  
  .qr-item--payment__info p {
    font-size: 10pt;
    line-height: 11pt;
  }
  
  .page-break {
    page-break-after: always;
  }
  
  </style>
  
  <div class="page-break"></div>
  <div class="qr cf">
    <div class="qr-item qr-item--receipt">
      <div class="qr-item--receipt__information">
        <h1>Empfangsschein</h1>
        <div>
          <h2>Konto / Zahlbar an</h2>
          <p>
            {{config('invoice.qr_iban')}}<br>
            {{config('invoice.beneficiary_name')}}<br>
            {{config('invoice.beneficiary_byline')}}<br>
            {{config('invoice.beneficiary_street')}}<br>
            {{config('invoice.beneficiary_city')}}<br>
          </p>
        </div>
        <div>
          <h2>Referenz</h2>
          <p>{{$payment_slip['reference_number']}}</p>
        </div>
        <div>
          <h2>Zahlbar durch</h2>
          <p>
            {{dd($invoice)}}
            @if (isset($invoice['client_type']))
              @if ($invoice['client_type'] == 'other')
                {!! nl2br($invoice['client']) !!}
              @elseif($invoice['client_type'] == 'tutor')
                {{ $invoice['client']->fullName}}<br>
                @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
                {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
                {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
              @elseif($invoice['client_type'] == 'student')
                @if ($invoice['client']->has_alt_address)
                  {{ $invoice['client']->alt_company}}<br>
                  @if ($invoice['client']->alt_name) {{ $invoice['client']->alt_name}}<br> @endif
                  {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
                  {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
                @else
                  {{ $invoice['client']->fullName}}<br>
                  @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
                  {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
                  {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
                @endif
              @endif
            @elseif (isset($invoice['client']))
              @if(isset($invoice['alt_address']))
                {!! nl2br($invoice['alt_address']) !!}
              @else
                @if (isset($invoice['client']->has_alt_address))
                  {{ $invoice['client']->alt_company}}<br>
                  {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
                  {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
                @else
                  {{ $invoice['client']->fullName}}<br>
                  {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
                  {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
                @endif
              @endif
            @elseif (isset($invoice['student']))
              @if ($invoice['student']->has_alt_address)
                {{ $invoice['student']->alt_company}}<br>
                {{ $invoice['student']->alt_name}}<br>
                {{ $invoice['student']->alt_street}} {{ $invoice['student']->alt_street_no}}<br>
                {{ $invoice['student']->alt_zip}} {{ $invoice['student']->alt_city}}
              @else
                {{ $invoice['student']->fullName}}<br>
                {{ $invoice['student']->street}} {{ $invoice['student']->street_no}}<br>
                {{ $invoice['student']->zip}} {{ $invoice['student']->city}}<br>
              @endif
            @endif
          </p>
        </div>
      </div>
      <div class="qr-item--receipt__amount">
        <div class="currency">
          <h2>Währung</h2>
          <p>CHF</p>
        </div>
        <div class="amount">
          <h2>Betrag</h2>
          <p>{{ number_format($invoice['invoice_amount'], 2, '.', ' ') }}</p>
        </div>
      </div>
      <div class="qr-item--receipt__acceptance">
        <p>Annahmestelle</p>
      </div>
    </div>
    <div class="qr-item qr-item--payment cf">
      <div class="qr-item--payment__left">
        <h1>Zahlteil</h1>
        <div class="qr-item--payment__code">
          <img src="{{$payment_slip['qr_code']}}" height="100" width="100" style="">
        </div>
        <div class="qr-item--payment__amount">
          <div class="currency">
            <h2>Währung</h2>
            <p>CHF</p>
          </div>
          <div class="amount">
            <h2>Betrag</h2>
            <p>{{ number_format($invoice['invoice_amount'], 2, '.', ' ') }}</p>
          </div>
        </div>
      </div>
      <div class="qr-item--payment__right">
        <div class="qr-item--payment__info">
          <div>
            <h2>Konto / Zahlbar an</h2>
            <p>
              {{config('invoice.qr_iban')}}<br>
              {{config('invoice.beneficiary_name')}}<br>
              {{config('invoice.beneficiary_byline')}}<br>
              {{config('invoice.beneficiary_street')}}<br>
              {{config('invoice.beneficiary_city')}}<br>
            </p>
          </div>
          <div>
            <h2>Referenz<h2>
            <p>{{$payment_slip['reference_number']}}</p>
          </div>
          <div>
            <h2>Zahlbar durch</h2>
            <p>
              @if (isset($invoice['client_type']))
                @if ($invoice['client_type'] == 'other')
                  {!! nl2br($invoice['client']) !!}
                @elseif($invoice['client_type'] == 'tutor')
                  {{ $invoice['client']->fullName}}<br>
                  @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
                  {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
                  {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
                @elseif($invoice['client_type'] == 'student')
                  @if ($invoice['client']->has_alt_address)
                    {{ $invoice['client']->alt_company}}<br>
                    @if ($invoice['client']->alt_name) {{ $invoice['client']->alt_name}}<br> @endif
                    {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
                    {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
                  @else
                    {{ $invoice['client']->fullName}}<br>
                    @if ($invoice['client']->title) {{ $invoice['client']->title}}<br> @endif
                    {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
                    {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
                  @endif
                @endif
              @elseif (isset($invoice['client']))
                @if(isset($invoice['alt_address']))
                  {!! nl2br($invoice['alt_address']) !!}
                @else
                  @if (isset($invoice['client']->has_alt_address))
                    {{ $invoice['client']->alt_company}}<br>
                    {{ $invoice['client']->alt_street}} {{ $invoice['client']->alt_street_no}}<br>
                    {{ $invoice['client']->alt_zip}} {{ $invoice['client']->alt_city}}
                  @else
                    {{ $invoice['client']->fullName}}<br>
                    {{ $invoice['client']->street}} {{ $invoice['client']->street_no}}<br>
                    {{ $invoice['client']->zip}} {{ $invoice['client']->city}}<br>
                  @endif
                @endif
              @elseif (isset($invoice['student']))
                @if ($invoice['student']->has_alt_address)
                  {{ $invoice['student']->alt_company}}<br>
                  @if ($invoice['student']->alt_name)
                    {{ $invoice['student']->alt_name}}<br>
                  @endif
                  {{ $invoice['student']->alt_street}} {{ $invoice['student']->alt_street_no}}<br>
                  {{ $invoice['student']->alt_zip}} {{ $invoice['student']->alt_city}}
                @else
                  {{ $invoice['student']->fullName}}<br>
                  {{ $invoice['student']->street}} {{ $invoice['student']->street_no}}<br>
                  {{ $invoice['student']->zip}} {{ $invoice['student']->city}}<br>
                @endif
              @endif
            </p> 
          </div>
        </div>
      </div>
    </div>
  </div>