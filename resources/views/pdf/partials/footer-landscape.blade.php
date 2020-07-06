<script type="text/php">
  if ( isset($pdf) ) {
    $date = date('d.m.Y', time());
    $font = $fontMetrics->get_font("helvetica", "regular");
    $pdf->page_text(58, 565, $date . " Seite {PAGE_NUM}/{PAGE_COUNT}", $font, 8, array(0,0,0));
  }
</script>
</body>
</html>