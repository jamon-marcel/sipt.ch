<style>
@page {
  size: A4 landscape;
  margin: 45mm 10mm 10mm 20mm;
}

@media print {
  html, body {
    width: 297mm;
    height: 210mm;
  }
}

/* Header */
header {
  height: 35mm;
  left: 0;
  right: 0;
  top: -35mm;
  position: fixed;
  width: 100%;
}

table.sender-data {
  width: 100%;
}

table.sender-data td:first-child {
  width: 210mm;
}

table.sender-data td:last-child {
  width: 75mm;
}

table.sender-data td:first-child {
  font-size: 8pt;
}

table.sender-data td img {
  display: inline-block;
  height: 30mm;
  position: relative;
  width: 56mm;
}

.content {
  padding-bottom: 5mm;
  position: relative;
  width: 267mm;
  z-index: 100;
}
</style>    