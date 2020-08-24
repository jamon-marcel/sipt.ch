@component('mail::message')
# Neues Buch – Orientierung für den komplexen Prozess der Traumabehandlung
<p>Liebe Kolleginnen, liebe Kollegen</p>
<p>Gerne mache ich Sie auf mein neues Buch aufmerksam, dass vor einer Woche bei Klett-Cotta erschienen ist.</p>
<p>Freundliche Grüsse<br><br>Rosmarie Barwinski<br>SIPT Schweizer Institut für Psychotraumatologie</p>
<br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('newsletter_cancel', ['newsletterSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent