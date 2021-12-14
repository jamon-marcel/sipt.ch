@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>Mit dem <a href="https://sipt.ch/storage/downloads/sipt-aufbau_06.pdf" target="_blank" class="anchor" style="color: #ff7a00; text-decoration: none;">6. Aufbau-Tipp</a> führt Sie Karin Salm in den Murg-Auen-Park, wo sich Mensch und Biber wohlfühlen.</p>
<p>Beste Grüsse<br>Rosmarie Barwinski</p>
<br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('newsletter_cancel', ['newsletterSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent