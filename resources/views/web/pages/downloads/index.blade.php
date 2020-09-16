@extends('web.layout.grids.1-1')
@section('seo_title', 'Downloads')
@section('seo_description', 'Nützliche Dokumente und Unterlagen zum Download')
@section('section')
<section class="theme-light">
  <x-header title="Downloads" />
  <article>
    <a href="/storage/downloads/sipt-bildungsangebot-fuer-beraterinnen.pdf" target="_blank" class="btn-download" title="Bildungsangebot für BeraterInnen">
      <strong>Bildungsangebot für BeraterInnen</strong> [PDF, 70KB]
    </a>
  </article>
  <article>
    <a href="/storage/downloads/sipt-bildungsangebot-fuer-paedagoginnen.pdf" target="_blank" class="btn-download" title="Bildungsangebot für PädagogInnen">
      <strong>Bildungsangebot für PädagogInnen</strong> [PDF, 70KB]
    </a>
  </article>
  <article>
    <a href="/storage/downloads/sipt-bildungsangebot-fuer-psychotherapeutinnen.pdf" target="_blank" class="btn-download" title="Bildungsangebot für Psychotherapeutinnen">
      <strong>Bildungsangebot für PsychotherapeutInnen</strong> [PDF, 70KB]
    </a>
  </article>
  <article>
    <a href="/storage/downloads/sipt-lageplan.pdf" target="_blank" class="btn-download" title="Download Lageplan">
      <strong>Lageplan SIPT</strong> [PDF, 936KB]
    </a>
  </article>
  <article>
    <a href="/storage/downloads/sipt-kursbeurteilung.pdf" target="_blank" class="btn-download" title="Download Kursbeurteilung">
      <strong>Kursbeurteilung</strong> [PDF, 522KB]
    </a>
  </article>
  <article>
    <a href="/storage/downloads/sipt-anmeldung-zertifikatsstudium-CAS-2019.pdf" target="_blank" class="btn-download" title="Download Anmeldung Zertifikatsstudium CAS">
      <strong>Anmeldung CAS</strong> [PDF, 237KB]
    </a>
  </article>
</section>
@endsection