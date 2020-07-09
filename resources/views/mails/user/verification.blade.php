@component('mail::message')
# Ihre Registration
<p>Vielen Dank für Ihre Registration beim SIPT.</p>
<p>Um Ihre Registration abzuschliessen, müssen Sie ihre E-Mail-Adresse bestätigen, klicken Sie bitte auf folgenden Button:</p>
<br>
<p><a href="{{ $verifyUrl }}" class="button button-primary">E-Mail Bestätigen</a></p>
<br>
<p>Sobald Ihre E-Mail-Adresse bestätigt ist, können Sie sich mit untenstehenden Zugangsdaten einloggen:</p>
<table class="content-table" cellpadding="0" cellspacing="0" style="max-width: 400px">
  <tr>
    <td>Benutzername:</td>
    <td style="text-align: right">{{$user->email}}</td>
  </tr>
  <tr>
    <td>Passwort:</td>
    <td style="text-align: right">{{$user_data['password']}}</td>
  </tr>
</table>
<br>
@include('mails.partials.html.signature')
<br>
<p><small>Sollte der Button "E-Mail Bestätigen" nicht funktionieren, kopieren Sie die untenstehende URL und fügen Sie sie in Ihren Browser ein:<br><span class="break-all">{{ $verifyUrl }}</span></small></p>
@endcomponent
