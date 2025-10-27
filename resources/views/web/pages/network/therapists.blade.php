@extends('web.layout.grids.1-1')
@section('seo_title', 'SIPT zertifizierte TherapeutInnen')
@section('seo_description', 'Anfragen zur Zertifizierung einer Traumastation können bei der Leitung des SIPT eingereicht werden')
@section('section')
<section class="theme-light">
  <x-header title="Netzwerk" />

  <article>
    <h2>SIPT zertifizierte TherapeutInnen</h2>
    @if($intro && $intro->content)
      <div>{!! $intro->content !!}</div>
    @endif
  </article>
  
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Schweiz</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display:none">
      @if($switzerlandTherapists && $switzerlandTherapists->count() > 0)
        @foreach($switzerlandTherapists as $therapist)
          <strong>{{ $therapist->title ? $therapist->title . ' ' : '' }}{{ $therapist->firstname }} {{ $therapist->name }}</strong><br>
          {!! $therapist->description !!}
        @endforeach
      @endif
    </div>
  </article>

  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Deutschland</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display:none">
      @if($germanyTherapists && $germanyTherapists->count() > 0)
        @foreach($germanyTherapists as $therapist)
          <strong>{{ $therapist->title ? $therapist->title . ' ' : '' }}{{ $therapist->firstname }} {{ $therapist->name }}</strong><br>
          {!! $therapist->description !!}
        @endforeach
      @endif
    </div>
  </article>
</section>
@endsection