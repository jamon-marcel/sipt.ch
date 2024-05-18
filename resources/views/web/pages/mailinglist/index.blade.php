@extends('web.layout.grids.2-1')
@section('seo_title', 'Newsletter & Aktuelles')
@section('seo_description', 'Das SIPT wünscht Ihnen in Ihrer Tätigkeit viele kleine positive Momente – Momente, die wir alle brauchen, um die Belastungen unserer Tätigkeit, aber auch das aktuelle Zeitgeschehen zu verarbeiten. Mit kurzen „Aufbau-Tipps” will das SIPT in unregelmässigen Abständen zu solchen Momenten beitragen.')
@section('section')
<section class="theme-dark">
  <x-header title="Newsletter & Aktuelles" />

  <article>
    <h2>Aufbau-Tipp</h2>
    <p>Das SIPT wünscht Ihnen in Ihrer Tätigkeit viele kleine positive Momente – Momente, die wir alle brauchen, um die Belastungen unserer Tätigkeit, aber auch das aktuelle Zeitgeschehen zu verarbeiten. Mit kurzen „Aufbau-Tipps” will das SIPT in unregelmässigen Abständen zu solchen Momenten beitragen.</p>
  </article>

  <article>
    <a href="/storage/downloads/sipt-aufbau_11.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 11 / Mai 2024</strong>
    </a>
    <div class="list">
      <div class="list__item">Schaurig schön, übers Moor zu wandern</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>

  <article>
    <a href="/storage/downloads/sipt-aufbau_10.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 10 / Dezember 2023</strong>
    </a>
    <div class="list">
      <div class="list__item">Eulenhäuser und Stadtumbau am Rhein</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderungg</div>
    </div>
  </article>

  <article>
    <a href="/storage/downloads/sipt-aufbau_09.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 9 / Mai 2023</strong>
    </a>
    <div class="list">
      <div class="list__item">Eine ausgezeichnete Landschaft</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_08.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 8 / Dezember 2022</strong>
    </a>
    <div class="list">
      <div class="list__item">Vom barocken Kleinstort zum barocken Spektakel</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_07.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 7 / Mai 2022</strong>
    </a>
    <div class="list">
      <div class="list__item">Die Planstadt und das Blumendorf im Klettgau</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_06.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 6 / Dezember 2021</strong>
    </a>
    <div class="list">
      <div class="list__item">Im Murg-Auen-Park fühlen sich Mensch, Biber & Co. wohl</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_05.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 5 / Mai 2021</strong>
    </a>
    <div class="list">
      <div class="list__item">Wie aus Abfall ein Paradies entsteht</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_04.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 4 / Januar 2021</strong>
    </a>
    <div class="list">
      <div class="list__item">Eine Waldkathedrale mit Aussicht</div>
      <div class="list__item">Ein Ausflug im Winter, Frühling, Sommer und Herbst</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_03.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 3 / Januar 2020</strong>
    </a>
    <div class="list">
      <div class="list__item">Tosende Wasser und die grosse Ruhe</div>
      <div class="list__item">Eine Winter – Frühlings – Sommer – Herbst – Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_02.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 2 / Juli 2019</strong>
    </a>
    <div class="list">
      <div class="list__item">Von Revolutionärinnnen & Nonnen, Kunst & Natur</div>
      <div class="list__item">Sommer Wanderung</div>
    </div>
  </article>
  <article>
    <a href="/storage/downloads/sipt-aufbau_01.pdf" target="_blank" class="btn-download" title="Download PDF">
      <strong>Aufbau-Tipp Nr. 1 / Januar 2019</strong>
    </a>
    <div class="list">
      <div class="list__item">„Bachtel du Riese, breit hin gelagerter nebelumwallter Götterberg“</div>
      <div class="list__item">Winter Wanderung</div>
    </div>
  </article>
</section>
<section class="theme">
  @if (isset($message))
    @if ($message == 'pending_confirmation')
      <article>
        <h2>Anmeldung Newsletter</h2>
        <p>Vielen Dank für Ihre Anmeldung. Sie erhalten in den nächsten Minuten eine E-Mail mit einem Link zur Bestätigung Ihrer E-Mail-Adresse.</p>
      </article>
    @endif
    @if ($message == 'lists_updated')
      <article>
        <h2>Abonnements aktualisiert</h2>
        <p>Vielen Dank. Wir haben ihre Newsletter-Abonnements aktualisiert.</p>
      </article>
    @endif
    @if ($message == 'confirmed')
      <article>
        <h2>Anmeldung Newsletter</h2>
        <p>Vielen Dank – Ihre Adresse ist hiermit bestätigt.</p>
      </article>
    @endif
  @else
    <article>
      <h2>Anmeldung Newsletter</h2>
      <p>Ja, ich möchte den SIPT Newsletter und Aufbau-Tipps per Mail erhalten. Zusätzlich können fachbezogene Newsletter abonniert werden:</p>
    </article>
    @if ($errors->any())
      <x-alert type="danger" message="{{__('messages.general_error')}}" />
    @endif
    <form method="POST" class="registration" action="{{ route('mailinglist_register') }}">
      @csrf
      @honeypot
      <x-mailinglists />
      <div class="sb-lg">
        <x-text-field label="E-Mail" type="email" name="email" />
      </div>
      <div class="form-buttons align-end">
        <x-button label="Anmelden" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
      </div>
    </form>
  @endif
</section>
@endsection