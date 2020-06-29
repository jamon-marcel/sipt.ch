@extends('web.layout.grids.1-1')
@section('seo_title', 'Das SIPT > Leitung / Dozierende')
@section('seo_description', 'Das SIPT setzt sich für Anliegen von Traumaopfern ein und bietet Fortbildungen für verschiedene Berufsgruppen an, die in ihrer Arbeit mit traumatisierten Menschen konfrontiert sind')
@section('section')
<section class="theme-light tutors">
  <x-header title="Das SIPT" />
  @include('web.pages.about.partials.list')
</section>
@endsection