@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>Mit dem <a href="https://sipt.ch/storage/downloads/sipt-aufbau_08.pdf" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">8. Aufbau-Tipp</a> führt Sie Karin Salm vom Etzelpass nach Einsiedeln vorbei an barocken Kleinstorten und Spektakeln, die in der Klosterstadt ihren Höhepunkt finden.</p>
<p>Beste Grüsse<br>Rosmarie Barwinski</p>
<br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent