<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style>
@media only screen and (max-width: 600px) {
  
  .header {
    padding: 24px 24px 48px 24px !important;
    text-align: right;
  }

  .inner-body {
    padding-bottom: 18px !important;
    width: 100% !important;
  }

  .content-cell {
    padding: 0 24px !important;
  }

  p {
    margin: 0 0 12px 0 !important;
  }

  .footer {
    padding: 24px 0 !important;
    width: 100% !important;
  }

  .footer p {
    margin-bottom: 18px !important;
  }

  h1 {
    margin: 0 0 18px 0 !important;
  }
}

</style>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td align="center">
      <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      {{ $header ?? '' }}
      <!-- Email Body -->
      <tr>
        <td class="body" width="100%" cellpadding="0" cellspacing="0">
          <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
          <!-- Body content -->
          <tr>
          <td class="content-cell">
          {{ Illuminate\Mail\Markdown::parse($slot) }}
          {{ $subcopy ?? '' }}
          </td>
          </tr>
          </table>
        </td>
      </tr>
      {{ $footer ?? '' }}
      </table>
    </td>
  </tr>
</table>
</body>
</html>
