@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>Wir bieten folgenden neuen Kurse für BeraterInnen an:</p>
<p><a href="https://psychotraumatologie-sipt.ch/bildungsangebot/modul/einfuehrung-in-die-beratungssituation-mit-komplextraumatisierten-patient-innen/9b14eb73-1309-487a-a03a-42860e521d2d" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">Einführung in die Beratungssituation mit komplextraumatisierten Patient/-innen</a>, (Dozentin: Maya Schenkel)</p>
<p>Beste Grüsse<br>Rosmarie Barwinski</p><br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent