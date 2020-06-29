<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>sipt.ch</title>
<style>
@page {
  size: A4;
  margin: 55mm 10mm 10mm 20mm;
}

@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
}

strong {
  font-family: Helvetica, Arial, sans-serif;
  font-weight: 700;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
}

td {
  padding: 0;
}

img {
  border: 0;
  vertical-align: middle;
}

body {
  color: #000000;
  font-size: 10pt;
  font-family: Helvetica, Arial, sans-serif;
  line-height: 1.25;
  text-rendering: optimizeLegibility;
}


/* Header */
header {
  height: 45mm;
  left: 0;
  right: 0;
  top: -45mm;
  position: fixed;
  width: 100%;
}

table {
  width: 100%;
}

table td {
  text-align: left;
  vertical-align: top;
}

table.sender-data,
table.recipient-data {
  width: 100%;
}

table.sender-data td:first-child,
table.recipient-data td:first-child {
  width: 105mm;
}

table.sender-data td:last-child,
table.recipient-data td:last-child {
  width: 75mm;
}

table.sender-data td:first-child {
  font-size: 8pt;
}

table.recipient-data td:first-child {
  font-size: 10pt;
}

table.recipient-data td {
  height: 25mm;
}

table.sender-data td img {
  display: inline-block;
  height: 30mm;
  position: relative;
  width: 56mm;
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
  text-align: right;
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
  margin-top: 8mm;
}


h1 {
  font-weight: bold;
  font-size: 13pt;
  line-height: 1;
  margin: 0 0 3mm 0;
}

.align-right {
  text-align: right;
}

.align-left {
  text-align: left;
}

.clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}

.content {
  position: relative;
  width: 180mm;
  z-index: 100;
}

</style>
</head>
<body>
<header>
  <table class="sender-data">
    <tr>
      <td>Neuwiesenstrasse 95<br>CH-8400 Winterhtur<br>+41 (0)52 213 41 12<br><br>www.sipt.ch<br>sekretariat@sipt.ch</td>
      <td>
        <img src="{{ asset('/assets/img/logo-sipt-print.svg') }}" width="100" class="logo-sipt">
      </td>
    </tr>
  </table>
</header>
<script type="text/php">
if (isset($pdf)) {
    $font = $fontMetrics->getFont("PostGroteskMedium", "normal");
    $pdf->page_text(863, 797, "{PAGE_NUM}", $font, 9, array(0, 0, 0));
}
</script>
<footer></footer>