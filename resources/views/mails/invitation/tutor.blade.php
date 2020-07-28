@component('mail::message')
# Neue Webseite
<p>Lorem ipsum dolor.</p>
<p>Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor</p>
<br>
<br>
<p>Sobald Ihre E-Mail-Adresse bestätigt ist, können Sie sich mit untenstehenden Zugangsdaten einloggen:</p>
<table class="content-table" cellpadding="0" cellspacing="0" style="max-width: 400px">
  <tr>
    <td>Benutzername:</td>
    <td style="text-align: right">[email]</td>
  </tr>
  <tr>
    <td>Passwort:</td>
    <td style="text-align: right">[passwort]</td>
  </tr>
</table>
<br>
@include('mails.partials.html.signature')
@endcomponent
