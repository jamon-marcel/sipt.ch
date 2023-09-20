@extends('web.layout.grids.1-1')
@section('seo_title', 'Das SIPT > Leitung / Dozierende')
@section('seo_description', 'Das SIPT setzt sich für Anliegen von Traumaopfern ein und bietet Fortbildungen für verschiedene Berufsgruppen an, die in ihrer Arbeit mit traumatisierten Menschen konfrontiert sind')
@section('section')
<section class="theme-light tutors">
  <x-header title="Das SIPT" />
  @include('web.pages.about.partials.list')
</section>
<section class="theme-medium">
  <h3>Podcasts</h3>
  <div class="sa-lg">
    Erleben Sie unsere Dozierenden live.
  </div>
  <div class="sa-lg">
    <strong>Podcast "Kurze Einführung"</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Podcast_Kurze_Einfuehrung.mp3" type="audio/mpeg">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Bea Götz</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Bea_Goetz.wav" type="audio/wav">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Damir Del Monte </strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Damir_Del_Monte.mp3" type="audio/mpeg">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Franz Holderegger</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Franz_Holderegger.wav" type="audio/wav">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Maria Teresa Diez Grieser</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Maria_Teresa_Diez_Grieser.mp3" type="audio/mpeg">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Markus Rachl</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Markus_Rachl.wav" type="audio/wav">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit David Zimmermann</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Prof._Dr._David_Zimmermann.wav" type="audio/wav">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Rosmarie Barwinski</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Prof._Rosmarie_Barwinki.wav" type="audio/wav">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Ruth Monstein</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Ruth_Monstein.mp3" type="audio/mpeg">
    </audio>
  </div>
  <div class="sa-lg">
    <strong>Interview mit Thomas Weber</strong><br>
    <audio controls class="sb-sm">
      <source src="/storage/audio/Interview_Thomas_Weber.wav" type="audio/wav">
    </audio>
  </div>
</section>
@endsection