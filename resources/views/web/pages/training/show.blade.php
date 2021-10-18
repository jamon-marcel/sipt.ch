@extends('web.layout.grids.1-1')
@section('seo_title', $training->title)
@section('seo_description', strip_tags($training->description_short))
@section('section')
<section class="theme-light">
  <x-header title="Bildungsangebot" />

  @if ($training->description_short)
    <article>
      <h2>{{$training->title}}</h2>
      {!! $training->description_short !!}
    </article>

    @if ($training->description)
      <article class="collapsible js-clpsbl">
        <h2>
          <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Beschreibung</a>
        </h2>
        <div class="collapsible__content js-clpsbl-body" style="display:none">
          {!! $training->description !!}
        </div>
      </article>
    @endif

  @else
    <article>
      <h2>{{$training->title}}</h2>
      {!! $training->description !!}
    </article>
  @endif

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
  
  @if ($training->courses)
    <article class="collapsible is-expanded js-clpsbl">
      <h2>
        <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Module</a>
      </h2>
      <div class="collapsible__content js-clpsbl-body" style="display:block">
        <div class="list">
          @foreach($training->courses as $course)
          <div class="list__item">
            <a href="{{ route('course_show', ['slug' => AppHelper::slug($course->title), 'course' => $course->id]) }}" class="icon-arrow">
              {{ $course->title }}
            </a>
          </div>
          @endforeach
        </div>
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

  @if ($training->is_cas)
    <article>
      <a href="/storage/downloads/sipt-anmeldung-zertifikatsstudium-CAS-2019.pdf" target="_blank" class="btn-download" title="Download Anmeldung Zertifikatsstudium CAS">
        <strong>Anmeldeformular CAS</strong> [PDF, 237KB]
      </a>
    </article>
  @endif

</section>
<x-quote size="is-sm" quote="Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen." author="Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie" />

@endsection