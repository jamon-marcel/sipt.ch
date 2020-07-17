<style>

@font-face {
  font-family: 'OCRBRegular';
  src: url({{ storage_path('fonts/OCRBRegular.ttf') }}) format("truetype");
  font-weight: 400;
  font-style: normal;
}

table.invoice-meta-data {
  margin-bottom: 5mm;
}

table.invoice-meta-data td {
  font-size: 10pt;
}

table.invoice-meta-data td:first-child {
  width: 30mm;
}

table.invoice-positions thead td {
  border-bottom: .15mm solid #000000;
  font-weight: 700;
  padding-bottom: 3mm;
}

table.invoice-positions tbody td {
  padding-top: 3mm;
}

table.invoice-positions td {
  padding-right: 2mm;
}

table.invoice-positions td.description {
  padding-right: 4mm;
}

table.invoice-positions td.qty,
table.invoice-positions td.unit,
table.invoice-positions td.price {
  width: 15mm;
}

table.invoice-positions td.number {
  width: 20mm;
}

table.invoice-positions td.price {
  padding-right: 0 !important;
  text-align: right;
  width: 20mm;
}

table.invoice-total {
  margin-top: 10mm;
}

table.invoice-total td {
  border-top: .1mm solid #000000;
  border-bottom: .3mm solid #000000;
  padding: 2mm 0 3mm 0;
  font-weight: 700;
  width: 50%;
}

table.invoice-total td:last-child {
  text-align: right;
}

.invoice-conditions {
  font-size: 8pt;
  margin-top: 5mm;
}

.payment-slip {
  height: 106mm;
  left: -20mm;
  position: relative;
  top: 15mm;
  width: 210mm;
}

.payment-slip img {
  display: block;
  height: 106mm;
  width: 210mm;
}

.payment-item {
  font-family: 'OCRBRegular';
  font-size: 9pt;
  line-height: 8pt;
  position: absolute;
}

.payment-item.payment-item__reference {
  font-size: 10pt;
  top: 34mm;
  left: 127mm;
}

.payment-item.payment-item__reference-small {
  font-size: 10pt;
  top: 59mm;
  left: 2mm;
  text-align: right;
  width: 55mm;
}

.payment-item.payment-item__amount-left,
.payment-item.payment-item__amount-left-cents,
.payment-item.payment-item__amount-right,
.payment-item.payment-item__amount-right-cents {
  font-size: 12pt;
  height: 5mm;
  letter-spacing: .5mm;
  padding-left: .5mm;
  text-align: right;
  top: 51mm;
}

.payment-item.payment-item__amount-left {
  left: 1mm;
  width: 40mm;
}

.payment-item.payment-item__amount-left-cents {
  width: 10mm;
  left: 47mm;
}

.payment-item.payment-item__amount-right {
  left: 62mm;
  width: 40mm;
}

.payment-item.payment-item__amount-right-cents {
  left: 108mm;
  width: 10mm;
}

.payment-item.payment-address-left,
.payment-item.payment-address-right {
  font-size: 10pt;
  width: 55mm;
}

.payment-item.payment-address-left {
  left: 2mm;
  top: 70mm;
}

.payment-item.payment-address-right {
  left: 124.4mm;
  top: 47mm;
}

.payment-item.payment-codeline {
  font-size: 12pt;
  letter-spacing: .01mm;
  left: 68mm;
  top: 88mm;
  width: 140mm;
}
</style>