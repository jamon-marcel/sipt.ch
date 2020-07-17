@extends('errors.app')
@section('content')
<main role="main" class="site">
<div class="grid-2-1">
  <div>@include('web.layout.partials.menu.site')</div>
  <section class="theme-light">
    <x-header title="Fehler 404" />
    <article>
      <h2>Hoppla - Seite nicht gefunden</h2>
      <p>Die gewünschte Seite konnte leider nicht gefunden werden.</p>
    </article>
  </section>
</main>
@endsection