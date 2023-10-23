@component('mail::message')
<p>Liebe Kolleginnen und Kollegen</p>
<p>Gerne machen wir Sie auf folgende Tagung aufmerksam, die unsere Dozentin Dr. rer. nat. Birgit Mayer mitorganisiert hat:</p>
<p><strong>Trauma und Traumafolgestörung bei Menschen mit Beeinträchtigung Diagnostik, Therapie und Begleitung</strong></p>
<p>Herzliche Grüsse<br>Prof. em. Dr. Rosmarie Barwinski<br>Leitung SIPT</p><br>
<p style="font-size: 14px; margin-bottom: 0">Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent