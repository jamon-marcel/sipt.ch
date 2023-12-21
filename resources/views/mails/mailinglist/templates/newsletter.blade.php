@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>In unserem <a href="https://sipt.ch/storage/downloads/sipt-aufbau_10.pdf" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">10. Aufbautipp</a> führt Sie Kulturjournalistin Karin Salm vom Basler Rheinhafen rheinaufwärts nach Birsfelden entlang der Uferpromenade vorbei an zahlreichen urbanen Entdeckungen. Die Wanderung, die beim Handelstor zur Welt beginnt, bietet beim Endpunkt ein Bravourstück populärer Baukunst.</p>
<p>Beste Grüsse<br>Rosmarie Barwinski</p>
<br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent