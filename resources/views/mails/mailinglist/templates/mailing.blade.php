@php
  $mailinglist = $subscriber ? $subscriber->mailinglist : null;

  // Versandgruppen mit eigenem Fusszeilen-Text (z.B. einmalige Versände an
  // Tagungsteilnehmende) erhalten ihren Text, alle anderen den Newsletter-Hinweis.
  $footerIntro = $mailinglist && $mailinglist->footer_text
    ? nl2br(e($mailinglist->footer_text)) . ' Sie möchten keine weiteren E-Mails erhalten?'
    : 'Sie erhalten diese Mail, da Sie den Newsletter «' . e($mailinglist ? $mailinglist->description : '[Mailingliste]') . '» abonniert haben. Sie möchten keine News vom SIPT mehr erhalten?';
@endphp
@component('mail::message')
{!! nl2br($salutation) !!}
{!! $body !!}
{!! nl2br($greetings) !!}
<br><br>
<p style="font-size: 14px; margin-bottom: 0">{!! $footerIntro !!} Klicken Sie bitte <span class="break-all"><a href="{{ route('mailinglist_cancel', ['mailinglistSubscriber' => $subscriber ?? 'ead0']) }}" class="anchor" style="color: #ff7a00; text-decoration: none;">hier</a>.</span></p>
@endcomponent
