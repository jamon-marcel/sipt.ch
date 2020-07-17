@component('mail::message')
# 2. Mahnung
<p>Guten Tag {{ $recipient->fullName }}</p>
<p>Wir haben festgestellt, dass die beiliegende Rechnung noch nicht beglichen wurde. Dürfen wir Sie bitten, diese raschmöglichst zu begleichen?</p>
<p>Sollte sich Ihre Zahlung mit diesem Schreiben gekreuzt haben, bitten wir um Entschuldigung.</p>
@include('mails.partials.html.signature')
@endcomponent
