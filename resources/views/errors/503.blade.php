@extends('errors.app')
@section('content')
<main role="main" class="site">
<div class="grid-2-1">
  <div>@include('web.layout.partials.menu.site')</div>
  <section class="theme-light">
    <x-header title="Fehler 503" />
    <article>
      <h2>Wartungsarbeiten - Service unavailable</h2>
      <p>Wir überarbeiten zur Zeit unsere Website und sind gleich wieder da.</p>
    </article>
  </section>
</main>
@endsection