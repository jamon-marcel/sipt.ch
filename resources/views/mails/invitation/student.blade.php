@component('mail::message')
# Liebe Kursbesucherinnen, liebe Kursbesucher
<p>Es freut mich sehr Ihnen/Euch anzukündigen, dass unser Institut für Psychotraumatologie ab Anfang August eine neue Homepage erhält. Sie ist im Wesentlichen übersichtlicher und man kann über sie administrative Umtriebe vereinfachen. Auch die künftige Buchung und Umbuchung von Kursen wird einfacher. Ihr alle könnt dies künftig selbst vornehmen. Dazu erhalten Sie/ erhältst Du einen individuellen Zugangs-Code (siehe unten stehend), über den das Einloggen möglich wird.</p>
<p>Über den eigenen Zugangs-Code können die eigenen Daten verwaltet werden, besuchte Kurse abgerufen werden und – wie bereits erwähnt – Buchungen und Umbuchungen einfacher vorgenommen werden. Bei Fragen können Sie/ kannst Du Dich gerne an unser Sekretariat oder mich wenden.</p>
<p>Ich wünsche Ihnen einen schönen Sommer und erholsame Ferien.</p>
<br>
<table class="content-table" cellpadding="0" cellspacing="0" style="max-width: 400px">
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
<p>Herzliche Grüsse<br>Rosmarie Barwinski</p>

@endcomponent
