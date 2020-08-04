@component('mail::message')
# Neue Webseite

<p>Liebe Kolleginnen, liebe Kollegen</p>
<p>Es freut mich sehr Euch ankündigen zu können, dass wir ab Anfang August eine neue Homepage aufschalten konnten. Sie ist wesentlich übersichtlicher und erlaubt allen DozentInnen, die eigenen Daten zu verwalten, Texte zu eigenen Kursen zu modifizieren und Termine zu überprüfen.</p>
<p>Dazu erhaltet ihr einen individuellen Zugangs-Code (siehe untenstehend), über den das Einloggen ins eigene Profil möglich wird.</p>
<p>Bei Fragen könnt ihr Euch gerne an unser Sekretariat oder mich wenden!</p>
<p>Gleichzeitig möchten wir Euch an unsere Tagung, am 10. Oktober 2020, erinnern. Das Tagungsprogramm findet Ihr im Anhang.</p>
<p>Ich wünsche Euch einen erholsamen Sommer.</p>
<br>
<table class="content-table" cellpadding="0" cellspacing="0" style="max-width: 400px">
  <tr>
    <td>Webseite:</td>
    <td style="text-align: right">https://www.psychotraumatologie-sipt.ch</td>
  </tr>  
  <tr>
    <td>Benutzername:</td>
    <td style="text-align: right">{{$email}}</td>
  </tr>
  <tr>
    <td>Passwort:</td>
    <td style="text-align: right">{{$password}}</td>
  </tr>
</table>
<br>
<p>Freundliche Grüsse<br>Rosmarie Barwinski<br>SIPT Schweizer Institut für Psychotraumatologie</p>
@endcomponent
