@extends('web.layout.grids.1-1')
@section('seo_title', $training->title)
@section('seo_description', '')
@section('section')
<section class="theme-light">
  <x-header title="Bildungsangebot" />
  <article>
    <h2>{{$training->title}}</h2>
    {!! $training->description !!}
  </article>
  
  @if ($training->structure)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Aufbau der Fortbildung</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        {!! $training->structure !!}
      </div>
    </article>
  @endif

  @if ($training->thesis)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Abschlussarbeit</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        {!! $training->thesis !!}
      </div>
    </article>
  @endif

  @if ($training->supervision)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Supervision</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        {!! $training->supervision !!}
      </div>
    </article>
  @endif

  @if ($training->certification)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Zertifizierung</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        {!! $training->certification !!}
      </div>
    </article>
  @endif

  @if ($training->cost)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Kosten</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        {!! $training->cost !!}
      </div>
    </article>
  @endif

  @if ($training->courses)
    <article class="collapsible js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Module</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:none">
        <div class="list">
          @foreach($training->courses as $course)
          <div class="list__item">
            <a href="{{ route('course_show', ['slug' => AppHelper::slug($course->title), 'course' => $course->id]) }}">
              {{ $course->title }}
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </article>
  @endif
</section>
<x-quote size="is-sm" quote="Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen." author="Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie" />

@endsection