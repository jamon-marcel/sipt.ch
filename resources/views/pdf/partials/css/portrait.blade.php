<style>
@page {
  size: A4;
  margin: 55mm 10mm 0mm 20mm;
}

@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
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

.content {
  position: relative;
  width: 180mm;
  z-index: 100;
}

</style>    