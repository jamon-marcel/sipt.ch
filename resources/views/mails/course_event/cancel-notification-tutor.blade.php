@component('mail::message')
# Modul abgesagt
<p>Guten Tag {{ $tutor->fullName }}</p>
<p>Das Modul «{{$courseEvent->course->title}}» wurde abgesagt.</p>
<br>
<table class="content-table" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120">Modul:</td>
    <td>{{ $courseEvent->course->title }}</td>
  </tr>
  <tr>
    <td width="120">Datum:</td>
    <td>{{ AppHelper::datesToString($courseEvent->dates) }}</td>
  </tr>
</table>
<br>
@include('mails.partials.html.signature')
@endcomponent
