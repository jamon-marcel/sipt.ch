@extends('web.layout.grids.1-1')
@section('seo_title', 'FAQ')
@section('seo_description', 'Die wichtigsten Fragen und Antworten zu den Ausbildungen am SIPT')
@section('section')
<section class="theme-light">
  <x-header title="FAQ" />
  <article>
    <h2>FAQ</h2>
    <p>Die wichtigsten Fragen und Antworten zu den Ausbildungen am SIPT</p>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Wie sind die Ausbildungen aufgebaut?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Die Ausbildungen am SIPT zeichnen sich durch ein flexibles Baukastensystem aus, das speziell für Berufstätige konzipiert ist. Beginnend mit dem Grundkurs können danach die Pflichtmodule sowie Wahlmodule besucht werden. Der Grundkurs ist die Voraussetzung für alle weiteren Module. Nach diesem Einstieg entscheiden Sie sich für eine Fachrichtung (z. B. Fachberatung, Traumapädagogik oder Traumatherapie). Das System ist modular: Sie buchen und bezahlen in der Regel Kurs für Kurs.</p>
      <ul>
        <li><strong>FachberaterIn für Psychotraumatologie und FachpädagogIn für Psychotraumatologie:</strong> 11 Module + 4 Supervisionen + Abschlussarbeit.</li>
        <li><strong>CAS (Certificate of Advanced Studies):</strong> 15 Module + 5 Supervisionen + Selbststudium + Diplomarbeit (umfassender).</li>
        <li><strong>FachpsychotherapeutIn für Psychotraumatologie:</strong> 11 Module + 4 Supervisionen + Abschlussarbeit.</li>
        <li><strong>CAS (Certificate of Advanced Studies):</strong> 12 Module + 5 Supervisionen + Selbststudium + Diplomarbeit (umfassender).</li>
      </ul>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Worin unterscheiden sich Pflicht- und Wahlmodule?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Wahlmodule sind genauso anrechenbar an die Ausbildungen wie Pflichtmodule.</p>
      <ul>
        <li><strong>Pflichtmodule</strong> decken den Kern des SIPT-Curriculums ab (z. B. Neurobiologie des PTSD, Akute Traumatisierung, Stabilisierung, Umgang mit Übertragung und Gegenübertragung). Diese müssen besucht werden, um den Abschluss oder das Zertifikat zu erhalten.</li>
        <li><strong>Wahlmodule</strong> ermöglichen eine individuelle Schwerpunktsetzung (z. B. Trauma und Migration oder Vertiefung dissoziative Störungen). Sie zählen vollumfänglich zur geforderten Gesamtanzahl der Module.</li>
      </ul>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Wann ist ein Ausbildungsbeginn möglich?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>In der Regel viermal im Jahr. Da der Einstieg immer über den Grundkurs erfolgt, können Sie zu jedem der vier Grundkurs-Termine im Jahr (ca. alle 3 Monate) Ihre Ausbildung beginnen.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Wie flexibel kann ich meine Ausbildung gestalten?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Sie können Ihre Ausbildung sehr flexibel und individuell gestalten. Nach dem Grundkurs bestimmen Sie das Tempo selbst. Sie können Module blockweise besuchen oder über einen längeren Zeitraum strecken, je nach Ihren zeitlichen und finanziellen Ressourcen.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Darf ich Wahlmodule aus verschiedenen Fachrichtungen belegen?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Im Prinzip ja. Viele Module sind interdisziplinär offen. Es gibt jedoch spezifische Module, die nur für zugelassene Psychotherapeuten (Fachrichtung Traumatherapie) reserviert sind, wie beispielsweise bestimmte traumakonfrontierende Behandlungstechniken. Für den Abschluss zur FachberaterIn für Psychotraumatologie oder FachpädagogIn für Psychotraumatologie können Sie jedoch aus einem breiten Angebot auch themenverwandter Module wählen, sofern diese für Ihr Berufsbild relevant sind.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Ist die Reihenfolge der Module frei wählbar?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Ja. Nach dem Grundkurs gibt es keine starre Reihenfolge. Das SIPT empfiehlt jedoch, grundlegende Module wie «Neurobiologie des PTSD» oder «Akute Traumatisierung» eher am Anfang zu besuchen, da sie das Verständnis für spätere Spezialthemen erleichtern.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Was unterscheidet den Abschluss «FachberaterIn/-pädagogIn» vom «CAS-Zertifikat»?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <ol>
        <li><strong>FachberaterIn/-pädagogIn (Zertifikat SIPT/DIPT):</strong> Dies ist der institutsinterne Abschluss. Er erfordert weniger Module (11) und ist kostengünstiger. Er ist ideal für die direkte Anwendung in der Praxis ohne akademischen Anspruch.</li>
        <li><strong>CAS (Certificate of Advanced Studies):</strong> Dies ist ein Hochschulzertifikat (in Kooperation mit einer Universität, z. B. des Swiss Campus). Der CAS erfordert mehr Module (15), mehr Supervision (5 statt 4), einen höheren akademischen Arbeitsaufwand (ECTS-Punkte) und ist teurer (Immatrikulationsgebühren). Er ist international akademisch anerkannt.</li>
      </ol>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Worin liegen die Unterschiede zwischen den Fachrichtungen?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <ul>
        <li><strong>Fachpädagogik vs. Traumapädagogik:</strong> Die Inhalte überschneiden sich stark (ca. 60%). Der Unterschied liegt im Fokus der Abschlussarbeit und spezifischen Wahlmodulen (z. B. Fokus Schule/Jugendhilfe bei Pädagogik vs. Beratung von Erwachsenen bei der Fachberatung).</li>
        <li><strong>Fachberatung vs. Traumatherapie:</strong> Die Therapie-Weiterbildung richtet sich ausschliesslich an approbierte Psychotherapeuten und Ärzte. Sie beinhaltet klinische Diagnostik und Behandlungstechniken, die in der Beratung nicht angewendet werden. Die Beratung fokussiert auf Stabilisierung, Psychoedukation und Begleitung im sozialen Kontext.</li>
      </ul>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Ist ein späterer Wechsel vom Fachberater-Lehrgang in den CAS möglich?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Ja, das ist problemlos möglich, sofern Sie die Zulassungsvoraussetzungen für den CAS (Berufsabschluss und zwei Jahre Praxiserfahrung oder «sur dossier») erfüllen.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Werden bereits absolvierte Module bei einem Wechsel in den CAS angerechnet?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Ja. Alle bereits besuchten Module und Supervisionen werden 1:1 angerechnet. Sie müssen lediglich die Differenz (zusätzliche Module, zusätzliche Supervision, wissenschaftliche Arbeit, Immatrikulationsgebühr der Uni) nachholen bzw. bezahlen.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Kann ich Module auch einzeln ohne Prüfungsabsicht besuchen?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Ja. Sie können jedes Modul als einzelne Fortbildung besuchen und erhalten dafür eine Teilnahmebestätigung, ohne sich sofort für einen gesamten Lehrgang verpflichten zu müssen.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Was beinhaltet das Modul «Fallkonzeption»?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Die «Fallkonzeption» ist ein spezifisches Modul (meist gegen Ende der Ausbildung). Hier stellen Sie Ihren Abschlussfall vor.</p>
      <ul>
        <li><strong>Inhalt:</strong> Sie analysieren einen Fall aus Ihrer Praxis anhand des am SIPT gelehrten Konzepte (Verlaufsmodell, Traumadynamik sowie Übertragung und Gegenübertragung).</li>
        <li><strong>Ziel:</strong> Es werden Übertragungs- und Gegenübertragungsphänomene herausgearbeitet und Handlungsstrategien diskutiert. Dieses Modul dient der Vorbereitung auf die schriftliche Abschlussarbeit.</li>
      </ul>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Erhalte ich die Kursunterlagen vorab?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Die Kursunterlagen, einschliesslich Skripte und Materialien, können Sie ca. eine Woche vor Kursbeginn von unserer Homepage herunterladen. Es wird empfohlen, diese Unterlagen (digital oder ausgedruckt) zum Kurs mitzubringen.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Mit welchen Gesamtkosten muss ich rechnen?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <ul>
        <li><strong>Einzelmodul:</strong> 450.– (für 1,5 Tage)</li>
        <li><strong>Supervision:</strong> 200.– (für einen halben Tag / 4 Einheiten)</li>
        <li><strong>FachberaterIn und FachpädagogIn (Gesamt):</strong> 5'750.- (inkl. aller Module und Supervisionen)</li>
        <li><strong>CAS für BeraterInnen und PädagogInnen (Gesamt):</strong> 8800.– (inkl. 1050.- Universitätsgebühren)</li>
        <li><strong>Fachpsychotherapeutin (Gesamt):</strong> 5'750.- (inkl. aller Module und Supervisionen)</li>
        <li><strong>CAS für Psychotherapeutinnen (Gesamt):</strong> 7350.– (inkl. 950.- Universitätsgebühren)</li>
      </ul>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Sind die Ausbildungskosten als Einmalzahlung fällig?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Nein, der Gesamtbetrag muss nicht auf einmal beglichen werden.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Ist eine modulweise Bezahlung möglich?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>Ja. Sie erhalten pro gebuchtes Modul eine Rechnung. Dies entspricht einer zinslosen Ratenzahlung über die Dauer Ihrer Ausbildung.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Wann werde ich über die definitive Durchführung eines Moduls informiert?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <p>In der Regel erhalten Sie die definitive Durchführungsbestätigung und Rechnung ca. 4 Wochen vor Kursbeginn.</p>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Welchen beruflichen Mehrwert bietet mir eine Ausbildung am SIPT?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <ul>
        <li><strong>Spezialisierung:</strong> Traumawissen wird in sozialen, pädagogischen und pflegerischen Berufen immer wichtiger. Traumasensibilität ist ein Qualitätsmerkmal für Institutionen.</li>
        <li><strong>Handlungssicherheit:</strong> Sie lernen nicht nur Theorie, sondern konkretes «Handwerkszeug» für schwierige Situationen (Dissoziation, Flashbacks).</li>
        <li><strong>Anerkennung:</strong> Mit einem CAS erwerben Sie einen international anerkannten Hochschultitel (ECTS-Punkte), was bei Bewerbungen oder Lohnverhandlungen ein Vorteil ist.</li>
      </ul>
    </div>
  </article>
  <article class="collapsible js-clpsbl">
    <h2>
      <a href="javascript:;" class="btn-collapsible js-clpsbl-btn">Was zeichnet das SIPT im Vergleich zu anderen Anbietern aus?</a>
    </h2>
    <div class="collapsible__content js-clpsbl-body" style="display: none">
      <ul>
        <li><strong>Fokus auf Psychodynamik:</strong> Im Gegensatz zu vielen rein technikorientiert Anbietern stehen am SIPT psychodynamische Konzepte im Vordergrund. Das Institut lehrt spezifisch die Mehrdimensionale Psychodynamische Traumatherapie (MPTT) sowie beziehungsorientierte traumazentrierte Beratung. Der Schwerpunkt liegt auf dem tiefen Verständnis von psychotraumatischen Syndromen, Komorbiditäten und der darauf aufbauenden Behandlungsplanung.</li>
        <li><strong>Beziehungsgestaltung:</strong> Das SIPT ist prozessorientiert und fokussiert auf die professionelle Gestaltung der therapeutischen oder beraterischen Beziehung. Es geht nicht nur um das Erlernen von Techniken (Tools), sondern um das tiefe Verstehen der Beziehungsgestaltung zu traumatisierten Menschen (z. B. Umgang mit Ohnmacht, Wut, Übertragung und Gegenübertragung).</li>
        <li><strong>Praxisnähe:</strong> Das Fortbildungskonzept zeichnet sich durch die Kombination aus fundierter Theorie und praxisnahem Unterricht aus. In Seminarform und Übungen in Kleingruppen wird der direkte Umgang mit Traumafolgeerscheinungen, Krisenintervention und Psychoedukation trainiert.</li>
        <li><strong>Interdisziplinarität:</strong> Therapeuten, Berater und Pädagogen lernen oft gemeinsam in Modulen, was den Blick über den Tellerrand fördert.</li>
      </ul>
    </div>
  </article>
</section>
@endsection

