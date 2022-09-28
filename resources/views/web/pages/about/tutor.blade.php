@extends('web.layout.grids.1-1')
@section('seo_title', 'Das SIPT > ' . $tutor->fullName)
@section('seo_description', 'Das SIPT setzt sich für Anliegen von Traumaopfern ein und bietet Fortbildungen für verschiedene Berufsgruppen an, die in ihrer Arbeit mit traumatisierten Menschen konfrontiert sind')
@section('section')
<section class="theme-light tutor-profile {{ $tutor->images->first() ? 'has-portrait' : '' }}">
  <x-header title="Das SIPT" />
  <div class="content-grid-1x1">
    <nav class="tutors order-1">
      @include('web.pages.about.partials.list')
    </nav>
    <div class="tutor order-2">
      @if ($tutor->images->first())
        <figure>
          <img src="/image/portrait/{{$tutor->images->first()->name}}" width="" height="" alt="Portrait {{$tutor->fullName}}">
        </figure>
      @endif
      <div>
        <header>
          <h3>{{$tutor->fullName}}</h3>
          @if ($tutor->title)
            {{$tutor->title}}
          @endif
        </header>
        @if ($tutor->description)
          <article>
            {{$tutor->description}}
          </article>
        @endif
        @if ($tutor->media)
          <div class="media">
            {!! $tutor->media !!}
          </div>
        @endif


        @if ($tutor->emphasis)
          <article class="collapsible js-clpsbl">
            <h3>
              <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Themenschwerpunkte</a>
            </h3>
            <div class="collapsible__content js-clpsbl-body" style="display: none">
              {!! $tutor->emphasis !!}
            </div>
          </article>
        @endif
        @if ($tutor->publications)
          <article class="collapsible js-clpsbl">
            <h3>
              <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Veröffentlichungen</a>
            </h3>
            <div class="collapsible__content js-clpsbl-body" style="display: none">
              {!! $tutor->publications !!}
            </div>
          </article>
        @endif

        </div>
    </div>
  </div>
</section>
@endsection