@extends('web.layout.grids.2-1')
@section('seo_title', 'Anmeldung erfolgreich – 20 Jahre SIPT')
@section('section')
<section class="theme-light">
  <x-header title="Fachtagung" />
  <article>
    <h2>Anmeldung erfolgreich</h2>
    <p>Vielen Dank für Ihre Anmeldung zur Fachtagung «20 Jahre SIPT – Soziale Traumata und deren Auswirkungen in der Praxis».</p>
    <p>Sie erhalten in Kürze eine Bestätigung per E-Mail.</p>
    <div class="list">
      <div class="list__item">
        <strong>Datum:</strong> Freitag, 21. und Samstag, 22. August 2026
      </div>
      <div class="list__item">
        <strong>Ort:</strong> Alte Kaserne, Technikumstrasse 8, 8403 Winterthur
      </div>
    </div>
    <p><strong>Wir freuen uns auf Sie!</strong></p>
    <p><a href="{{ route('anniversary_index') }}" class="btn-primary">Zurück zur Übersicht</a></p>
  </article>
</section>
@endsection
