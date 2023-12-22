@extends('web.layout.grids.1-2')
@section('seo_title', 'Home')
@section('seo_description', 'Das SIPT setzt sich für Anliegen von Traumaopfern ein und bietet Fortbildungen für verschiedene Berufsgruppen an, die in ihrer Arbeit mit traumatisierten Menschen konfrontiert sind. Im Fortbildungsangebot des SIPT stehen psychodynamische Konzepte im Vordergrund.')
@section('section')
<section class="theme-light order-1">
  <x-header title="Aktuell" />
  
  <article>
    <h2>Trauma-Broschüren</h2>
    <p>Die Trauma-Broschüren des Zentrum für Trauma- und Konfliktmanagement ZTK unter der Leitung von Thomas Weber wurden auf Ukrainisch und Russisch übersetzt. Diese können für die Arbeit mit Geflüchteten jederzeit kostenfrei über die folgenden Links heruntergeladen werden:</p>
    <p>
      <strong>Ukrainisch</strong> (für die Arbeit mit <a href="https://www.unfallkasse-berlin.de/fileadmin/user_data/informationenfuer/Hilfeleistende/UKB_Broschuere_Trauma-Erwachsene_2022_ukr_final.pdf" target="_blank" title="">Erwachsenen</a> / <a href="https://www.unfallkasse-berlin.de/fileadmin/user_data/informationenfuer/Hilfeleistende/UKB_Broschuere_Trauma-Kinder_2022_ukr_final.pdf" target="_blank" title="">Kindern und Jugendlichen</a>)
    </p>
    <p>
      <strong>Russisch</strong> (für die Arbeit mit <a href="ttps://www.unfallkasse-berlin.de/fileadmin/user_data/informationenfuer/Hilfeleistende/UKB_Broschuere_Trauma-Erwachsene_2022_rus_final.pdf" target="_blank" title="">Erwachsenen</a> / <a href="https://www.unfallkasse-berlin.de/fileadmin/user_data/informationenfuer/Hilfeleistende/UKB_Broschuere_Trauma-Kinder_2022_rus_final.pdf" target="_blank" title="">Kindern und Jugendlichen</a>)
    </p>
    <p>Eine erweiterte Fassung der Broschüren in <strong>Deutsch</strong> können Sie in Papierform beim SIPT bestellen.</p>
  </article>

  <article>
    <h2>Neues Buch – Trauma und Gegenübertragung: Den Stand der Traumaverarbeitung erkennen und Behandlungsschritte planen</h2>
    <p>
      Gerne machen wir auf folgendes Buch aufmerksam, welches neu bei Klett-Cotta erscheint.<br>
      <a href="https://www.klett-cotta.de/buch/Trauma/Trauma_und_Gegenuebertragung/827446" target="_blank" class="icon-arrow-right">mehr erfahren</a>
    </p>
  </article>

  <article>
    <h2>Podcasts</h2>
    <p>Einige unserer Dozierenden können Sie neu im persönlichen Gespräch kennenlernen.<br>
      <a href="{{ route('about_tutors') }}" class="icon-arrow-right">mehr erfahren</a>
    </p>
  </article>

  <article>
    <h2>Neue Kursangebote</h2>
    <p>Gerne weisen wir auf <strong>aktuelle</strong> Kursangebote hin:</p>
  </article>

  <article>
    <h2>„Das Monster in mir“ – eine Aussage eines 8 j. Jungen</h2>
    <p>Der Kampf zwischen dem „Ich von Heute und Hier“ und den Täterintrojekten aus den traumatischen Situationen von damals und dort stehen im Mittelpunkt des Seminars.</p>
    <p>Die Begriffe: Täterintrojekt und täterinfizierte Anteile werden anhand von Fallbeispielen diskutiert.<br>Schwerpunkte werden der Umgang im pädagogischen Alltag und in der Therapie sowie der Schutz vor Eskalation sein. Die bösartigen Introjekte und deren selbstzerstörerische Wirkungen zu erkennen und zu begrenzen ist ebenfalls Inhalt des Seminars.<br>Eigene Beispiele der Teilnehmer*innen sind sehr willkommen.</p>
    <p>Dozentin: Natascha Unfried<br>Termin: 4./5.10.2024<br><a href="" class="icon-arrow-right">mehr erfahren</a></p>
  </article>

  <article>
    <h2>Traum und Trauma </h2>
    <p>Dozent: Lutz Wittmann<br>Termin: 9./10.02.2024</p>
    <p>
      Prof. Dr. phil. Lutz Wittmann lehrt und forscht an der IPU Berlin in Klinischer Psychologie und Psychotherapie mit Schwerpunkten in der Psychodynamischen Psychotherapie, Psychotraumatologie und Empirischen Traumforschung. Im neuen Modul «Traum und Trauma» am SIPT vermittelt er Teilnehmenden in einem interaktiven Seminar einen Überblick über die massgebenden Theorien und Forschungsbefunde zu posttraumatischen Albträumen. Weiter lernen Sie klinische Modelle auf Traumberichte traumatisierter Patienten anzuwenden, um Rückschlüsse für das therapeutische Vorgehen zu erarbeiten.<br>
      <a href="https://psychotraumatologie-sipt.ch/bildungsangebot/modul/traum-und-trauma-fakultativ/2058beb2-2ab8-4ce9-b0df-28d257498635" class="icon-arrow-right">mehr erfahren</a>
    </p>
  </article>

</section>
<section class="theme-medium order-2 splash visual">
  <div class="splash__title">Willkommen im Schweizer Institut für Psychotraumatologie</div>
  {{-- <div class="visual__container is-right has-max-w">
    <img src="/assets/img/visual-1.png" width="3996" height="2896" alt="">
  </div> --}}

</section>
@endsection