@component('mail::message')
{!! nl2br($salutation) !!}
{!! $body !!}
{!! nl2br($greetings) !!}
<br><br>
<p style="font-size: 14px; margin-bottom: 0">Sie erhalten diese Mail, da Sie die den Newsletter «{{ $subscriber ? $subscriber->mailinglist->description : '[Mailingliste]' }}» abonniert haben. Sie möchten keine News vom SIPT mehr erhalten? Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber ?? 'ead0']) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent