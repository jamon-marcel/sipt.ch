@extends('web.layout.grids.2-1')
@section('seo_title', '20 Jahre SIPT – Fachtagung')
@section('seo_description', 'Das SIPT wird 20 Jahre alt! Zweitägige Fachtagung zum Thema «Soziale Traumata und deren Auswirkungen in der Praxis» am 21. und 22. August 2026 in Winterthur.')
@section('section')

{{-- Main Content Column --}}
<section class="theme-light">
  <x-header title="Fachtagung" />
  <article>
    <h2>20 Jahre SIPT</h2>
    <p>Das SIPT wird dieses Jahr 20 Jahre alt! Dies möchten wir mit einer zweitägigen Fachtagung feiern und laden Sie herzlich dazu ein. Gemeinsam widmen wir uns dem Thema <strong>«Soziale Traumata und deren Auswirkungen in der Praxis»</strong>.</p>
    <p>Die aktuelle politische Weltlage, Kriege und der Klimawandel haben zunehmend Auswirkungen auf das psychische Befinden unserer PatientInnen in der Psychotherapie und Beratung, aber vor allem auch im pädagogischen Bereich. Mit unserer Tagung wollen wir einen Diskussionsraum öffnen, um Folgen sozialer Traumata aufzuzeigen und Probleme zu benennen, ohne in eine Polarisierung abzugleiten. Wir möchten nach Lösungen suchen, die einen hoffnungsvollen Blick in die Zukunft ermöglichen.</p>
  </article>
  <article>
    <div class="list">
      <div class="list__item">
        <strong>Datum:</strong> Freitag, 21. und Samstag, 22. August 2026
      </div>
      <div class="list__item">
        <strong>Ort:</strong> Alte Kaserne, Technikumstrasse 8, 8403 Winterthur
      </div>
    </div>
  </article>

  {{-- Collapsible: Programm --}}
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Programm</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <h3>Freitag, 21. August 2026</h3>
      <div class="program">
        <div class="program__item">
          <div class="program__time">ab 13.30 Uhr</div>
          <div class="program__desc">Eintreffen mit Kaffee</div>
        </div>
        <div class="program__item">
          <div class="program__time">14.00 Uhr</div>
          <div class="program__desc">Tagungseröffnung und Begrüssung</div>
        </div>
        <div class="program__item">
          <div class="program__time">15.00 Uhr</div>
          <div class="program__desc"><strong>Referat 1:</strong> «Trauma – zwischen individuellem Leid und gesellschaftlicher Realität»<br><em>Prof. Dr. phil. Lutz Wittmann (IPU Berlin)</em></div>
        </div>
        <div class="program__item">
          <div class="program__time">16.00 – 16.30 Uhr</div>
          <div class="program__desc">Pause</div>
        </div>
        <div class="program__item">
          <div class="program__time">16.30 Uhr</div>
          <div class="program__desc"><strong>Referat 2:</strong> «Wenn das Soziale zur Morphologie wird – Traumata aus neurobiologischer Sicht»<br><em>Dr. scient. med. Dr. phil. Damir del Monte (PMU Salzburg)</em></div>
        </div>
        <div class="program__item">
          <div class="program__time">17.30 Uhr</div>
          <div class="program__desc">Podiumsdiskussion mit Kurzvorstellungen</div>
        </div>
        <div class="program__item">
          <div class="program__time">18.30 – 19.30 Uhr</div>
          <div class="program__desc">Apéro</div>
        </div>
      </div>

      <h3>Samstag, 22. August 2026</h3>
      <div class="program">
        <div class="program__item">
          <div class="program__time">ab 8.30 Uhr</div>
          <div class="program__desc">Eintreffen mit Kaffee</div>
        </div>
        <div class="program__item">
          <div class="program__time">09.00 Uhr</div>
          <div class="program__desc"><strong>Referat 3:</strong> «Ethik versus Kritik: Ein Blick in die Reparaturkiste mit der Aufschrift «Ethik»»<br><em>PD Dr. phil. Thomas Kesselring (Universität Bern)</em></div>
        </div>
        <div class="program__item">
          <div class="program__time">10.00 Uhr</div>
          <div class="program__desc"><strong>Referat 4:</strong> «Kollektive Traumata, Schuld und Scham im Israel-Palästina-Konflikt»<br><em>Prof. Dr. José Brunner (Universität Tel Aviv)</em></div>
        </div>
        <div class="program__item">
          <div class="program__time">11.00 – 11.30 Uhr</div>
          <div class="program__desc">Pause</div>
        </div>
        <div class="program__item">
          <div class="program__time">11.30 Uhr</div>
          <div class="program__desc">Podiumsdiskussion mit Kurz-Referaten</div>
        </div>
        <div class="program__item">
          <div class="program__time">12.30 – 13.30 Uhr</div>
          <div class="program__desc">Mittagspause</div>
        </div>
        <div class="program__item">
          <div class="program__time">13.30 Uhr</div>
          <div class="program__desc"><strong>Referat 5:</strong> «Psychotherapie mit ehemaligen Kindersoldaten in Mozambique – Zyklen der Gewalt durchbrechen»<br><em>Dr. phil. Boia Efraime Junior (Uni. Maputo, Mozambique)</em></div>
        </div>
        <div class="program__item">
          <div class="program__time">14.30 Uhr</div>
          <div class="program__desc"><strong>Referat 6:</strong> «Hilfe für verletzte Seelen – Beziehungsgestaltung im Rahmen der psychosozialen Traumaarbeit»<br><em>Prof. Dr. phil. habil. Silke Birgitta Gahleitner (ASH Berlin)</em></div>
        </div>
        <div class="program__item">
          <div class="program__time">15.30 – 16.00 Uhr</div>
          <div class="program__desc">Pause</div>
        </div>
        <div class="program__item">
          <div class="program__time">16.00 Uhr</div>
          <div class="program__desc">Podiumsdiskussion mit Kurz-Referaten</div>
        </div>
        <div class="program__item">
          <div class="program__time">17.00 Uhr</div>
          <div class="program__desc">Abschlussworte und Ausblick</div>
        </div>
      </div>
    </div>
  </article>

  {{-- Collapsible: Tagungsgebühren --}}
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Tagungsgebühren</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <table class="table-default">
        <thead>
          <tr>
            <th>Ticket</th>
            <th>Preis</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Beide Tage (Fr + Sa) – Frühbuchertarif*</td>
            <td>CHF 350.–</td>
          </tr>
          <tr>
            <td>Beide Tage (Fr + Sa) – Normaltarif</td>
            <td>CHF 390.–</td>
          </tr>
          <tr>
            <td>Nur Freitag, 21.8.26</td>
            <td>CHF 150.–</td>
          </tr>
          <tr>
            <td>Nur Samstag, 22.8.26</td>
            <td>CHF 250.–</td>
          </tr>
        </tbody>
      </table>
      <p class="form-hint"><small>* Frühbucherrabatt gilt bis 30.05.2026</small></p>

      <h3>Inklusivleistungen</h3>
      <ul>
        <li>Apéro am Freitag, den 21.8.26 (Kosten in der Tagungsgebühr inklusive)</li>
        <li>Mittagessen am Samstag, den 22.8.26 (Kosten in der Tagungsgebühr inklusive)</li>
      </ul>
    </div>
  </article>
</section>

{{-- Sidebar: Registration Form --}}
<section class="theme">
  <article>
    <h2>Anmeldung</h2>
    <p>Ja, ich nehme an der Fachtagung teil</p>
  </article>
  @if ($errors->any())
    <x-alert type="danger" message="{{__('messages.general_error')}}" />
  @endif
  <form method="POST" class="registration" action="{{ route('anniversary_register') }}">
    @csrf
    @honeypot

    {{-- Anrede --}}
    <div class="form-group @if ($errors->has('salutation')) has-error @endif">
      <label class="is-required" for="salutation">Anrede</label>
      <select name="salutation" id="salutation" required>
        <option value="">Bitte wählen</option>
        <option value="Frau" {{ old('salutation') == 'Frau' ? 'selected' : '' }}>Frau</option>
        <option value="Herr" {{ old('salutation') == 'Herr' ? 'selected' : '' }}>Herr</option>
        <option value="Divers" {{ old('salutation') == 'Divers' ? 'selected' : '' }}>Divers</option>
      </select>
    </div>

    <x-text-field label="Vorname" name="firstname" required="true" />
    <x-text-field label="Name" name="name" required="true" />
    <x-text-field label="Titel" name="title" placeholder="optional" />
    <x-text-field label="E-Mail" type="email" name="email" required="true" />
    <x-text-field label="Telefon" name="phone" placeholder="optional" />
    <x-text-field label="Strasse" name="street" required="true" />
    <x-text-field label="Hausnummer" name="street_no" required="true" />
    <x-text-field label="PLZ" name="zip" required="true" />
    <x-text-field label="Ort" name="city" required="true" />

    <div style="margin-top: 30px;"></div>

    {{-- Ticket Selection: Stacked Buttons --}}
    <div class="form-group @if ($errors->has('ticket_type')) has-error @endif">
      <label class="is-required">Ticketauswahl</label>
    </div>
    <div class="ticket-buttons">
      <label class="ticket-button">
        <input type="radio" name="ticket_type" value="both_days" {{ old('ticket_type') == 'both_days' ? 'checked' : '' }} required>
        <span class="ticket-button__content">
          <strong>Beide Tage (Fr + Sa)</strong>
          <span>CHF 350.–* / CHF 390.–</span>
        </span>
      </label>
      <label class="ticket-button">
        <input type="radio" name="ticket_type" value="friday_only" {{ old('ticket_type') == 'friday_only' ? 'checked' : '' }}>
        <span class="ticket-button__content">
          <strong>Nur Freitag, 21.8.26</strong>
          <span>CHF 150.–</span>
        </span>
      </label>
      <label class="ticket-button">
        <input type="radio" name="ticket_type" value="saturday_only" {{ old('ticket_type') == 'saturday_only' ? 'checked' : '' }}>
        <span class="ticket-button__content">
          <strong>Nur Samstag, 22.8.26</strong>
          <span>CHF 250.–</span>
        </span>
      </label>
    </div>
    <p class="form-hint"><small>* Frühbucherrabatt gilt bis 30.05.2026</small></p>

    {{-- Conditional: Apéro Friday --}}
    <div class="form-group js-apero-section" style="display: none;">
      <label>Apéro – Freitag, 21.8.26</label>
      <div class="form-group-radio">
        <div>
          <input type="radio" name="apero_friday" value="1" id="apero_yes" {{ old('apero_friday') == '1' ? 'checked' : '' }}>
          <div class="radio"><span></span></div>
        </div>
        <label for="apero_yes">Ja, ich nehme teil</label>
      </div>
      <div class="form-group-radio">
        <div>
          <input type="radio" name="apero_friday" value="0" id="apero_no" {{ old('apero_friday') == '0' ? 'checked' : '' }}>
          <div class="radio"><span></span></div>
        </div>
        <label for="apero_no">Nein, ich nehme nicht teil</label>
      </div>
    </div>

    {{-- Conditional: Lunch Saturday --}}
    <div class="form-group js-lunch-section" style="display: none;">
      <label>Mittagessen – Samstag, 22.8.26</label>
      <div class="form-group-radio">
        <div>
          <input type="radio" name="lunch_saturday" value="1" id="lunch_yes" {{ old('lunch_saturday') == '1' ? 'checked' : '' }}>
          <div class="radio"><span></span></div>
        </div>
        <label for="lunch_yes">Ja, ich nehme teil</label>
      </div>
      <div class="form-group-radio">
        <div>
          <input type="radio" name="lunch_saturday" value="0" id="lunch_no" {{ old('lunch_saturday') == '0' ? 'checked' : '' }}>
          <div class="radio"><span></span></div>
        </div>
        <label for="lunch_no">Nein, ich nehme nicht teil</label>
      </div>
    </div>

    <div class="sb-md">
      <x-radio label="Ich bin mit den %toc% einverstanden" id="toc" name="toc" />
    </div>
    <div class="form-buttons align-end">
      <x-button label="Anmelden" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
    </div>
  </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const ticketRadios = document.querySelectorAll('input[name="ticket_type"]');
  const aperoSection = document.querySelector('.js-apero-section');
  const lunchSection = document.querySelector('.js-lunch-section');

  function updateConditionalSections() {
    const selectedTicket = document.querySelector('input[name="ticket_type"]:checked');
    if (!selectedTicket) {
      aperoSection.style.display = 'none';
      lunchSection.style.display = 'none';
      return;
    }

    const ticketType = selectedTicket.value;

    // Show apéro section for both_days or friday_only
    if (ticketType === 'both_days' || ticketType === 'friday_only') {
      aperoSection.style.display = 'block';
    } else {
      aperoSection.style.display = 'none';
    }

    // Show lunch section for both_days or saturday_only
    if (ticketType === 'both_days' || ticketType === 'saturday_only') {
      lunchSection.style.display = 'block';
    } else {
      lunchSection.style.display = 'none';
    }
  }

  ticketRadios.forEach(function(radio) {
    radio.addEventListener('change', updateConditionalSections);
  });

  // Initialize on page load
  updateConditionalSections();
});
</script>

<style>
.ticket-buttons {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 10px;
  width: 100%;
}

.ticket-button {
  display: block;
  width: 100%;
  cursor: pointer;
}

.ticket-button input[type="radio"] {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.ticket-button__content {
  display: block;
  width: 100%;
  padding: 15px 20px;
  border: 1px solid #ddd;
  background: #fff;
  transition: all 0.2s ease;
  box-sizing: border-box;
}

.ticket-button__content strong {
  display: block;
  margin-bottom: 3px;
}

.ticket-button__content span {
  font-size: 0.9em;
  color: #666;
}

.ticket-button input[type="radio"]:checked + .ticket-button__content {
  border-color: #ff7a00;
  background: #fff8f2;
}

.ticket-button:hover .ticket-button__content {
  border-color: #ff7a00;
}

.ticket-button input[type="radio"]:focus + .ticket-button__content {
  box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.2);
}

.form-hint {
  margin-top: 5px;
  margin-bottom: 20px;
}

.table-default {
  margin-top: 20px;
}

.table-default th {
  text-align: left;
}

.table-default tr {
  border-bottom: 1px solid #000;
}

.table-default td {
  padding-top: 5px;
  padding-bottom: 5px;
}

.table-default td:first-child {
  padding-right: 60px;
}

.collapsible__content h3:first-child {
  margin-top: 20px;
}

.program {
  margin-top: 15px;
  margin-bottom: 30px;
}

.program__item {
  display: flex;
  gap: 20px;
  padding: 4px 0;
  border-bottom: 1px solid #000;
}

.program__time {
  flex-shrink: 0;
  width: 180px;
}

.program__desc {
  flex: 1;
}

.program__desc em {
  display: block;
  margin-top: 3px;
}
</style>

@endsection
