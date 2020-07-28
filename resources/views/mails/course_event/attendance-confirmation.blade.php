@component('mail::message')
# Teilnahmebestätigung
<p>Guten Tag {{ $student->fullName }}</p>
<p>Vielen Dank für Ihre Teilnahme am Modul «{{$courseEvent->course->title}}». Die Bestätigung Ihrer Teilnahme erhalten Sie in der Beilage.</p>
@include('mails.partials.html.signature')
@endcomponent
