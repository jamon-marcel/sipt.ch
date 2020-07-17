@extends('errors.app')
@section('content')
<main role="main" class="site">
<div class="grid-2-1">
  <div>@include('web.layout.partials.menu.site')</div>
  <section class="theme-light">
    <x-header title="Fehler 429" />
    <article>
      <h2>Hoppla - Too many requests</h2>
      <p>Hoppla, etwas ist schiefgelaufen. Sollte das Problem weiterhin bestehen, wenden Sie sich an <a href="mailto:support@sipt.ch">support@sipt.ch</a>.</p>
    </article>
  </section>
</main>
@endsection