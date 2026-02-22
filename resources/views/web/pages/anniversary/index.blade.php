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
      <div class="list__item">
        <strong>Anerkennung & Credits:</strong> SIPT-Teilnahmebestätigung, FSP-Fortbildungseinheiten, FMH-Zertifizierung in Planung
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
          <div class="program__desc"><strong>Referat 6:</strong> «Hilfe für verletzte Seelen – Beziehungsgestaltung im Rahmen der psychosozialen Traumaarbeit»<br><em>Prof. Dr. phil. habil. Silke Birgitta Gahleitner (ASH Berlin) & Angela Marquardt (UBSKM)</em></div>
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

  {{-- Collapsible: Referenten & Abstracts --}}
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Referentenporträts und Abstracts</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">

      <div class="speaker">
        <p><strong>«Trauma – zwischen individuellem Leid und gesellschaftlicher Realität»</strong></p>
        <p>Prof. Dr. phil. Lutz Wittmann (IPU Berlin)</p>
        <p class="speaker__bio"><em>Zur Person:</em> Lutz Wittmann ist Professor für klinische Psychologie und Psychotherapie an der International Psychoanalytic University Berlin. Als profilierter Psychotraumatologe forscht er zu den psychosozialen Dimensionen von Traumata und der Verbindung zwischen individueller Psyche und sozialem Kontext.</p>
        <p class="speaker__abstract"><em>Abstract:</em> Längst haben wir das Paradigma einer Einpersonenpsychologie hinter uns gelassen und kontextualisieren menschliches Erleben in interpersonellen Zusammenhängen. Die aktuelle Weltlage gibt einmal mehr Anlass, die Interaktion individueller Psychopathologie und gesellschaftlicher Realität zu fokussieren. In diesem Beitrag werden das Prozesshafte des traumatischen Geschehens sowie seine sozialen Dimensionen herausgearbeitet und klinisch veranschaulicht. Dabei werden die Bedeutung und die Begrenztheit individueller wie kollektiver Traumakonzepte gleichermassen kritisch beleuchtet.</p>
      </div>

      <div class="speaker">
        <p><strong>«Wenn das Soziale zur Morphologie wird – Traumata aus neurobiologischer Sicht»</strong></p>
        <p>Dr. scient. med. Dr. phil. Damir del Monte (PMU Salzburg)</p>
        <p class="speaker__bio"><em>Zur Person:</em> Damir del Monte ist Neurowissenschaftler und Psychologe mit Schwerpunkt in der Depressions-, Trauma- und Schmerzforschung. Er lehrt an verschiedenen europäischen Universitäten und ist international dafür bekannt, komplexe neurobiologische Zusammenhänge verständlich und begeisternd zu vermitteln.</p>
        <p class="speaker__abstract"><em>Abstract:</em> Soziale Erfahrungen – insbesondere jene, die mit Unsicherheit, Ausgrenzung oder Gewalt einhergehen – hinterlassen im Gehirn nicht nur Spuren des Erlebten, sondern formen es buchstäblich um. Der Vortrag widmet sich der zentralen These, dass das Soziale morphologisch wird: Zwischenmenschliche Erfahrungen schreiben sich über neuroplastische Prozesse tief in die Struktur des Gehirns ein und beeinflussen dessen funktionelle Architektur nachhaltig. Der Beitrag schlägt eine Brücke zwischen sozialer Erfahrung und neurobiologischer Realität und lädt zur interdisziplinären Reflexion über ein zentrales Prinzip der menschlichen Existenz ein: Beziehung formt Biologie.</p>
      </div>

      <div class="speaker">
        <p><strong>«Ethik versus Kritik: Ein Blick in die Reparaturkiste mit der Aufschrift «Ethik»»</strong></p>
        <p>PD Dr. phil. Thomas Kesselring (Universität Bern)</p>
        <p class="speaker__bio"><em>Zur Person:</em> Thomas Kesselring ist Privatdozent für Philosophie an der Universität Bern mit Schwerpunkten in der Erkenntnistheorie und Ethik. Er zeichnet sich durch seine Fähigkeit aus, philosophische Grundsatzfragen mit aktuellen gesellschaftlichen Herausforderungen und psychologischen Aspekten zu verknüpfen.</p>
        <p class="speaker__abstract"><em>Abstract:</em> Wir leben in unsicheren Zeiten. Das belastet die Psyche und erschwert die politischen Entscheidungen. Die Frage, was wesentlich ist und was unwesentlich, wird kaum noch diskutiert. Wie konnte es so weit kommen? Nach einer hypothetischen Diagnose einiger Ursachen will ich ein paar ethische «Essentials» in Erinnerung rufen, die früher mal galten: Kooperation, statt nur immer Wettbewerb; Autonomie statt Manipulation; gegenseitige Achtung statt Ausgrenzung; Dezentrierung statt Zentrierung auf's Ego, die 'Identität', Partei, Nation usw. (Wie) lassen sich solche «Essentials» zurückgewinnen?</p>
      </div>

      <div class="speaker">
        <p><strong>«Kollektive Traumata, Schuld und Scham im Israel-Palästina-Konflikt»</strong></p>
        <p>Prof. Dr. José Brunner (Universität Tel Aviv)</p>
        <p class="speaker__bio"><em>Zur Person:</em> José Brunner ist emeritierter Professor an der Universität Tel Aviv und Experte für die politische Geschichte der Psychologie und des Traumas. Seine Arbeit befasst sich intensiv mit dem Zusammenspiel von Recht, Politik und psychischen Belastungen in hochgradig konfliktbehafteten Gesellschaften.</p>
        <p class="speaker__abstract"><em>Abstract:</em> Im Israel-Palästina-Konflikt prallen zwei Kollektive aufeinander, deren Identitäten eng an historische Traumata – Holocaust und Nakba – geknüpft sind. Der Vortrag zeigt, dass die langfristige Wirkung dieser Traumata auf Dynamiken kollektiver Schuld, Scham und deren Abwehr zurückzuführen ist, die Gewalt fördern. Untersucht werden die Ausdrucksformen dieser Dynamiken in beiden Gesellschaften. Diese sind sowohl Resultat des massiven Machtgefälles in diesem asymmetrischen Konflikt als auch der unterschiedlichen kulturellen Rahmenbedingungen, die beide Seiten prägen.</p>
      </div>

      <div class="speaker">
        <p><strong>«Psychotherapie mit ehemaligen Kindersoldaten in Mozambique – Zyklen der Gewalt durchbrechen»</strong></p>
        <p>Dr. phil. Boia Efraime Junior (Universität Maputo, Mozambique)</p>
        <p class="speaker__bio"><em>Zur Person:</em> Boia Efraime Junior ist ein führender mosambikanischer Psychologe und Experte für die Rehabilitation von Kindersoldaten. Er leitet innovative Projekte in Maputo, die traditionelle Heilmethoden mit westlicher Psychotherapie verbinden, um transgenerationale Gewaltzyklen nachhaltig zu durchbrechen.</p>
        <p class="speaker__abstract"><em>Abstract:</em> Mosambik ist geprägt von transgenerationalen Gewaltzyklen, die von der Kolonialzeit bis in aktuelle Konflikte reichen. Besonders die Rekrutierung von Kindersoldaten hinterlässt tiefe Spuren in der Psyche und Sozialstruktur. Dieser Beitrag analysiert die Folgen dieser Traumata, wie den Verlust familiärer Autoritäten. Vorgestellt wird ein psychotherapeutischer Ansatz, der durch die Anpassung psychoanalytischer Theorie sichere Gruppenräume schafft. Mittels traditionellen Storytellings werden alternative Identifikationsmodelle entwickelt, um Empathie zu stärken und Gewaltzyklen zu stoppen.</p>
      </div>

      <div class="speaker">
        <p><strong>«Hilfe für verletzte Seelen – Beziehungsgestaltung im Rahmen der psychosozialen Traumaarbeit»</strong></p>
        <p>Prof. Dr. phil. habil. Silke Birgitta Gahleitner (ASH Berlin) & Angela Marquardt (UBSKM)</p>
        <p class="speaker__bio"><em>Zu den Personen:</em> Silke Birgitta Gahleitner ist Professorin für Klinische Psychologie und Sozialarbeit an der Alice Salomon Hochschule in Berlin, langjährig als Sozialarbeiterin und Psychotherapeutin tätig. Seit 2022 ist sie Mitglied der Unabhängigen Aufarbeitungskommission zur Aufarbeitung sexuellen Kindesmissbrauchs. Angela Marquardt ist Diplom-Politologin und Referentin bei der Bundesbeauftragten für den Datenschutz und die Informationsfreiheit sowie Mitglied im Betroffenenrat bei der Unabhängigen Beauftragten für Fragen des sexuellen Kindesmissbrauchs. Die Autorin setzte sich unter anderem in ihrem Buch «Vater, Mutter, Stasi» intensiv mit ihrer Biografie im Überwachungsstaat der DDR auseinander.</p>
        <p class="speaker__abstract"><em>Abstract:</em> Traumatische Erschütterungen führen oft zu einer Fokussierung auf Schäden und Pathologien. Dabei wird übersehen, dass Betroffene oft enorme Überlebensleistungen erbringen. Eine rein symptomorientierte Sichtweise ignoriert diese Kraft und erschwert die konstruktive Bewältigung. Passfähige Unterstützung hängt primär von einer authentischen, emotional tragfähigen und fachlich reflexiven Beziehungsgestaltung ab. Der Vortrag vereint wissenschaftliche und erfahrungsorientierte Perspektiven zur Frage, wie Fachkräfte diesen Prozess der Bewältigung wirksam unterstützen können.</p>
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
      <label class="is-required">Ticketkauf</label>
    </div>
    <div class="ticket-buttons">
      {{-- Both Days --}}
      <div class="ticket-button" data-ticket="both_days">
        <label class="ticket-button__header">
          <input type="radio" name="ticket_type" value="both_days" {{ old('ticket_type') == 'both_days' ? 'checked' : '' }}>
          <span class="ticket-button__content">
            <span>CHF 350.–/CHF 390.–</span>
            <small>Frühbucherrabatt gilt bis 30.05.2026</small>
          </span>
        </label>
      </div>

    </div>

    {{-- Ticket Options (shown once both_days is selected) --}}
    <div class="form-group" id="js-ticket-options" style="{{ old('ticket_type') ? 'margin-top: 25px' : 'display: none; margin-top: 25px' }}">
      <div>
        <label style="margin-bottom: 10px">Inklusivleistungen</label>
        <div class="small">Bitte wählen Sie die Leistungen aus, die im Rahmen Ihrer Ticketbuchung inklusive sind.</div>
      </div>
    </div>
    <div class="ticket-options-container" id="js-ticket-options-content" style="{{ old('ticket_type') ? '' : 'display: none;' }}">
      <div class="ticket-option" id="js-apero-option">
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
      <div class="ticket-option" id="js-lunch-option">
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
