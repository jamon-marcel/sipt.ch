@component('mail::message')
# Vielen Dank für Ihre Anmeldung
<p>Um die Registration für unseren Newsletter abzuschliessen, klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_confirm', ['mailinglistSubscriber' => $subscriber->id]) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@include('mails.partials.html.signature')
<br>
<p><small>Sollte der Link nicht funktionieren, kopieren Sie die untenstehende URL und fügen Sie sie in Ihren Browser ein:<br><span class="break-all">{{ route('mailinglist_confirm', ['mailinglistSubscriber' => $subscriber->id]) }}</span></small></p>

@endcomponent