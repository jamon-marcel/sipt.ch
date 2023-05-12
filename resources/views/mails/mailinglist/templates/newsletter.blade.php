@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>In unserem <a href="https://sipt.ch/storage/downloads/sipt-aufbau_09.pdf" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">9. Aufbautipp</a> nimmt Sie Kulturjournalistin Karin Salm auf eine eindrückliche Ganzjahreswanderung ins Toggenburg zum mächtigsten Berg der sieben Churfirsten mit. Auf dem Chäserrugg haben die Architekten Herzog & de Meuron einen wahrhaftig naturbelassenen Tourismusbau geschaffen, der selbst fester Bestandteil der ausgezeichneten Berglandschaft wurde.</p>
<p>Beste Grüsse<br>Rosmarie Barwinski</p>
<br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent