<style>
@page {
  size: A4 landscape;
  margin: 85mm 10mm 10mm 20mm;
}

h1 {
  margin-bottom: .5mm;
}

h2 {
  font-weight: 400;
  font-size: 13pt;
  line-height: 1.2;
  margin: 0 0 3mm 0;
}

header {
  height: 75mm;
  top: -75mm;
}

.content-header {
  height: 20mm;
  left: 0;
  right: 0;
  top: -40mm;
  position: fixed;
  width: 100%;
}

.content {
  top: -30mm;
}

table.list-courses td {
  border-bottom: .15mm solid #000000;
}

table.list-courses {
  border: none;
  margin-top: 2mm;
  width: 100%;
}

table.list-courses thead th {
  padding-bottom: 2mm;
  text-align: left;
}

table.list-courses thead th,
table.list-courses tbody td {
  font-size: 8pt;
}

/* day 1 */
table.list-courses tbody td:nth-child(1) {
  width: 12mm;
}

/* day 2 */
table.list-courses tbody td:nth-child(2) {
  width: 12mm;
}

/* no. */
table.list-courses tbody td:nth-child(3) {
  width: 18mm;
}

/* description */
table.list-courses tbody td:nth-child(4) {
  width: 65mm;
}

/* tutor 1 */
table.list-courses tbody td:nth-child(5) {
  width: 25mm;
}

/* tutor 2 */
table.list-courses tbody td:nth-child(6) {
  width: 25mm;
}

/* times */
table.list-courses tbody td:nth-child(7) {
  width: 30mm;
}

/* location */
table.list-courses tbody td:nth-child(8) {
  width: 30mm;
}

/* students */
table.list-courses thead th:nth-child(9),
table.list-courses tbody td:nth-child(9) {
  text-align: right;
  width: 8mm;
}


</style>
