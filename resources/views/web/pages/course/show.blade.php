@extends('web.layout.grids.2-1')
@section('seo_title', $course->title)
@section('seo_description', )
@section('section')
<section class="theme-light">
  <x-header title="Bildungsangebot" />
  <article>
    <h2>{{$course->title}}</h2>
    {!! $course->description !!}
  </article>
  @if ($course->eventsBookable && isset($course->eventsBookable[0]))
    <article class="collapsible is-expanded js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Nächste Veranstaltung</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:block">
        @include('web.pages.course.partials.event', ['course' => $course, 'event' => $course->eventsBookable[0]])
      </div>
    </article>
  @endif
  @if ($course->eventsBookable && count($course->eventsBookable) > 1)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Weitere Veranstaltungen</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        @foreach($course->eventsBookable as $event)
          @if ($loop->index > 0)
            @include('web.pages.course.partials.event', ['course' => $course, 'event' => $event])
          @endif
        @endforeach
      </div>
    </article>
  @endif
</section>
<x-quote size="is-sm" quote="Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen." author="Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie" />
@endsection