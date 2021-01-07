@component('mail::message')
# Vielen Dank für Ihre Anmeldung
<p>Um die Registration für unseren Newsletter abzuschliessen, klicken Sie bitte <span class="break-all"><a href="{{ route('newsletter_confirm', ['newsletterSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@include('mails.partials.html.signature')
@endcomponent