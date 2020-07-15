@extends('web.layout.grids.2-1')
@section('seo_title', 'Buchung annulieren: ' . $courseEvent->course->title)
@section('seo_description', )
@section('section')
<section class="theme-light">
  <x-header title="Bildungsangebot" />
  <article>
    <h2>Annulation bestätigen</h2>
    <p>Bitte bestätigen Sie die Annulation ihrer Buchung:</p>
  </article>
  <article class="is-narrow">
    <div class="list list--event">
      <div class="list__item">
        {{$courseEvent->course->title}}
      </div>
      <div class="list__item">
        Datum: {{AppHelper::datesToString($courseEvent->dates)}}
      </div>
      <div class="list__item">
        DozentInnen: {{AppHelper::tutorsToString($courseEvent->dates, TRUE)}}
      </div>
      <div class="list__item">
        Kosten: CHF {{$courseEvent->course->cost}}.–
      </div>
    </div>
    <form class="booking" action="{{ route('booking_cancel_confirm') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{$id}}">
      <button type="submit">annulation bestätigen</button>
    </form>
  </article>
</section>
<x-quote size="is-sm" quote="Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen." author="Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie" />
@endsection