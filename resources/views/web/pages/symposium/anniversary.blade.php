@extends('web.layout.grids.2-1')
@section('seo_title', 'Jubiläums-Fachtagung — 15 Jahre SIPT')
@section('seo_description', 'Das SIPT feiert sein 15-jähriges Bestehen mit einer Fachtagung! Wie kann die Beziehung im Verlauf einer Traumatherapie, als auch im pädagogischen Kontext gestaltet werden, damit Entwicklung möglich wird?')
@section('section')
<section class="theme-light">
  <x-header title="Fachtagung" />
  <article>
    <h2>Jubiläums-Fachtagung — 15 Jahre SIPT<br>Neue Entwicklungen im psychodynamischen Traumaverständnis</h2>
    <p>Wie kann die Beziehung im Verlauf einer Traumatherapie, als auch im pädagogischen Kontext gestaltet werden, damit Entwicklung möglich wird?</p>
    <p>Dies wird Thema der Jubiläumstagung zum 15-jährigen Bestehen des SIPT sein. Dabei stehen symboltheoretische Überlegungen im Vordergrund.</p>
    <p>Prof. Dr. Reinhard Fatke zeigt auf, dass Phantasieren im Kindesalter als eine spezifische Form der Symbolbildung zur Bewältigung von irritierenden Erlebnissen verstanden werden kann.</p>
    <p>Dipl.- med. Natascha Unfried veranschaulicht, wie pränatal / präverbal erlebte Traumata innere Bilder nachhaltig gestalten und Prof. Dr. Pia Andreatta rundet den Vormittag mit ihrem Vortrag über Sprachbilder und Symbolisierung ab.</p>
    <p>Prof. Dr. Heinrich Deserno zeigt anschliessend auf, welche Bedeutung der Symbolbildung bei Panik- und Persönlichkeitsstörungen zukommt.</p>
    <p>Prof. Dr. Carl Scheidt erläutert abschliessend Spiegelungs – und Resonanzprozesse in der Therapie.</p>
  </article>
  <article>
    <div class="list">
      <a href="/storage/downloads/sipt-tagungsprogramm.pdf" target="_blank" class="btn-download" title="Download Tagungsprogramm">
        <strong>Ausführliches Programm</strong> [PDF, 804KB]
      </a>
      <div class="list__item">
        Samstag, 10. Oktober 2020
      </div>
      <div class="list__item">
        Zeit: 8:15 Uhr bis 17:30 Uhr
      </div>
      <div class="list__item">
        Ort: Alte Kaserne Winterthur
      </div>
      <div class="list__item">
        Kosten: CHF 200 
      </div>
    </div>
  </article>
</section>
@include('web.pages.symposium.partials.' . $sidebar)
@endsection