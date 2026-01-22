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
            <td>Beide Tage (Freitag und Samstag) – Frühbuchertarif*</td>
            <td>CHF 350.–</td>
          </tr>
          <tr>
            <td>Beide Tage (Freitag und Samstag) – Normaltarif</td>
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
      <select name="salutation" id="salutation">
        <option value="">Bitte wählen</option>
        <option value="Frau" {{ old('salutation') == 'Frau' ? 'selected' : '' }}>Frau</option>
        <option value="Herr" {{ old('salutation') == 'Herr' ? 'selected' : '' }}>Herr</option>
        <option value="Divers" {{ old('salutation') == 'Divers' ? 'selected' : '' }}>Divers</option>
      </select>
    </div>

    <x-text-field label="Vorname" name="firstname" showRequired="true" />
    <x-text-field label="Name" name="name" showRequired="true" />
    <x-text-field label="Titel" name="title" placeholder="optional" />
    <x-text-field label="E-Mail" type="email" name="email" showRequired="true" />
    <x-text-field label="Telefon" name="phone" placeholder="optional" />
    <x-text-field label="Strasse" name="street" showRequired="true" />
    <x-text-field label="Hausnummer" name="street_no" showRequired="true" />
    <x-text-field label="PLZ" name="zip" showRequired="true" />
    <x-text-field label="Ort" name="city" showRequired="true" />

    <div class="spacer-form"></div>

    {{-- Ticket Selection: Stacked Buttons --}}
    <div class="form-group @if ($errors->has('ticket_type')) has-error @endif">
      <label class="is-required">Ticketauswahl</label>
    </div>
    <div class="ticket-buttons">
      {{-- Both Days --}}
      <div class="ticket-button" data-ticket="both_days">
        <label class="ticket-button__header">
          <input type="radio" name="ticket_type" value="both_days" {{ old('ticket_type') == 'both_days' ? 'checked' : '' }}>
          <span class="ticket-button__content">
            <strong>Beide Tage (Freitag und Samstag)</strong>
            <span>CHF 350.–/CHF 390.–</span>
            <small>Frühbucherrabatt gilt bis 30.05.2026</small>
          </span>
        </label>
      </div>

      {{-- Friday Only --}}
      <div class="ticket-button" data-ticket="friday_only">
        <label class="ticket-button__header">
          <input type="radio" name="ticket_type" value="friday_only" {{ old('ticket_type') == 'friday_only' ? 'checked' : '' }}>
          <span class="ticket-button__content">
            <strong>Nur Freitag, 21.8.26</strong>
            <span>CHF 150.–</span>
          </span>
        </label>
      </div>

      {{-- Saturday Only --}}
      <div class="ticket-button" data-ticket="saturday_only">
        <label class="ticket-button__header">
          <input type="radio" name="ticket_type" value="saturday_only" {{ old('ticket_type') == 'saturday_only' ? 'checked' : '' }}>
          <span class="ticket-button__content">
            <strong>Nur Samstag, 22.8.26</strong>
            <span>CHF 250.–</span>
          </span>
        </label>
      </div>
    </div>

    {{-- Ticket Options (shown based on ticket selection) --}}
    <div class="form-group" id="js-ticket-options" style="{{ old('ticket_type') ? 'margin-top: 25px' : 'display: none; margin-top: 25px' }}">
      <div>
        <label style="margin-bottom: 10px">Inklusivleistungen</label>
        <div class="small">Bitte wählen Sie die Leistungen aus, die im Rahmen Ihrer Ticketbuchung inklusive sind.</div>
      </div>
    </div>
    <div class="ticket-options-container" id="js-ticket-options-content" style="{{ old('ticket_type') ? '' : 'display: none;' }}">
      <div class="ticket-option" id="js-apero-option" style="{{ in_array(old('ticket_type'), ['both_days', 'friday_only']) ? '' : 'display: none;' }}">
        <span class="ticket-option__label">Apéro (Freitag, 21.8.26)</span>
        <div class="ticket-option__radios">
          <label class="ticket-option__radio">
            <input type="radio" name="apero_friday" value="1" {{ old('apero_friday') == '1' ? 'checked' : '' }}>
            <span>Ja, ich nehme teil</span>
          </label>
          <label class="ticket-option__radio">
            <input type="radio" name="apero_friday" value="0" {{ old('apero_friday') == '0' ? 'checked' : '' }}>
            <span>Nein, ich nehme nicht teil</span>
          </label>
        </div>
      </div>
      <div class="ticket-option" id="js-lunch-option" style="{{ in_array(old('ticket_type'), ['both_days', 'saturday_only']) ? '' : 'display: none;' }}">
        <span class="ticket-option__label">Mittagessen (Samstag, 22.8.26)</span>
        <div class="ticket-option__radios">
          <label class="ticket-option__radio">
            <input type="radio" name="lunch_saturday" value="1" {{ old('lunch_saturday') == '1' ? 'checked' : '' }}>
            <span>Ja, ich nehme teil</span>
          </label>
          <label class="ticket-option__radio">
            <input type="radio" name="lunch_saturday" value="0" {{ old('lunch_saturday') == '0' ? 'checked' : '' }}>
            <span>Nein, ich nehme nicht teil</span>
          </label>
        </div>
      </div>
    </div>
    @if ($errors->has('ticket_type'))
      <span class="form-error">{{ $errors->first('ticket_type') }}</span>
    @endif

    <div class="sb-md">
      <x-radio label="Ich bin mit den %toc% einverstanden" id="toc" name="toc" showRequired="true" />
    </div>
    <div class="form-buttons align-end">
      <x-button label="Anmelden" name="register" btnClass="btn-primary" type="submit" />
    </div>
  </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var ticketRadios = document.querySelectorAll('input[name="ticket_type"]');
  var ticketButtons = document.querySelectorAll('.ticket-button');
  var optionsTitle = document.getElementById('js-ticket-options');
  var optionsContainer = document.getElementById('js-ticket-options-content');
  var aperoOption = document.getElementById('js-apero-option');
  var lunchOption = document.getElementById('js-lunch-option');

  function updateTicketOptions() {
    var selectedTicket = document.querySelector('input[name="ticket_type"]:checked');
    
    ticketButtons.forEach(function(button) {
      var radio = button.querySelector('input[name="ticket_type"]');
      if (radio.checked) {
        button.classList.add('is-selected');
      } else {
        button.classList.remove('is-selected');
      }
    });

    if (selectedTicket) {
      optionsTitle.style.display = 'flex';
      optionsContainer.style.display = 'block';
      var ticketType = selectedTicket.value;
      
      aperoOption.style.display = (ticketType === 'both_days' || ticketType === 'friday_only') ? 'block' : 'none';
      lunchOption.style.display = (ticketType === 'both_days' || ticketType === 'saturday_only') ? 'block' : 'none';
    } else {
      optionsTitle.style.display = 'none';
      optionsContainer.style.display = 'none';
    }
  }

  ticketRadios.forEach(function(radio) {
    radio.addEventListener('change', updateTicketOptions);
  });

  updateTicketOptions();

  // Prevent double submission
  var form = document.querySelector('form.registration');
  form.addEventListener('submit', function() {
    var submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Wird gesendet...';
  });
});
</script>

@endsection
