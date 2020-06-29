@extends('web.layout.grids.1-2')
@section('seo_title', 'Home')
@section('seo_description', '')
@section('section')
<section class="theme-light order-1">
  <x-header title="Aktuell" />
  <article>
    <h2>
      <a href="{{route('symposium_anniversary')}}">Jubiläums-Fachtagung — 15 Jahre SIPT</a>
    </h2>
    <p>Samstag 10. Oktober 2020<br>Neue Entwicklungen im psychodynamischen Traumaverständnis</p>
    <p>Das SIPT feiert sein 15-jähriges Bestehen mit einer Fachtagung! Wie kann die Beziehung im Verlauf einer Traumatherapie, als auch im pädagogischen Kontext gestaltet werden, damit Entwicklung möglich wird? <a href="{{route('symposium_anniversary')}}" class="icon-arrow-right">weiter</a></p>
  </article>
</section>
<section class="theme-medium order-2 splash splash--anniversary">
  <div class="splash__title">
    Willkommen im Schweizer Institut für Psychotraumatologie
  </div>
</section>
@endsection