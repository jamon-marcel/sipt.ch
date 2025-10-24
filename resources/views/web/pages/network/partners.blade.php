@extends('web.layout.grids.1-1')
@section('seo_title', 'Partner-Institutionen')
@section('seo_description', 'Anfragen zur Zertifizierung einer Traumastation können bei der Leitung des SIPT eingereicht werden')
@section('section')
<section class="theme-light">
  <x-header title="Netzwerk" />
  <article>
    <h2>Partner-Institutionen</h2>
  </article>
  @foreach($partners as $partner)
  <article class="collapsible is-expanded js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">{{ $partner->name }}</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body">
      {!! $partner->description !!}
    </div>
  </article>
  @endforeach
</section>
@endsection