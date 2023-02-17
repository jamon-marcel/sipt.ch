@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>Wir freuen uns, Ihnen mitteilen zu können, dass wir neue fachspezifische Newsletter-Listen zu unserem Newsletter hinzugefügt haben!</p>
<p>Um Ihre aktuellen Newsletter-Einstellungen zu verwalten, klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_manage', ['mailinglistSubscriber' => $subscriber->hash]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
<p>Beste Grüsse<br>Rosmarie Barwinski</p>
<br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent