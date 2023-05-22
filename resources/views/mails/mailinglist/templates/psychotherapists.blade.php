@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>Wir bieten folgende neuen Kurse für PsychotherapeutInnen an:</p>
<p><a href="https://psychotraumatologie-sipt.ch/bildungsangebot/modul/integration-einer-traumaverarbeitenden-behandlung-mit-emdr-in-ein-psychodynamisches-behandlungskonzept/5cd19b28-f7ca-4d0f-90fc-9ff8ce2b10ea" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">Integration einer traumaverarbeitenden Behandlung mit EMDR in ein psychodynamisches Behandlungskonzept</a>, (Dozentin: Dr. med. Sabine Röcker)</p>
<p><a href="https://psychotraumatologie-sipt.ch/bildungsangebot/modul/einfuehrung-in-die-therapie-mit-komplextraumatisierten-patient-innen/5a16ac2d-cf9d-4954-be93-fd630f54fa6c" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">Einführung in die Therapie mit komplextraumatisierten Patient/-innen</a>, (Dozentin: lic. phil. Maya Schenkel)</p>
<p>Weitere Informationen finden Sie auf unserer Homepage.</p>
<p>Herzliche Grüsse<br>Rosmarie Barwinski</p><br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent