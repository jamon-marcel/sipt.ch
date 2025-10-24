<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PartnerInstitution;

class InsertPartnerInstitutions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partners:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert default partner institutions into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Inserting partner institutions...');

        $institutions = [
            [
                'name' => 'Deutsches Institut für Psychotraumatologie (DIPT)',
                'description' => '<p>Springen 26<br>53804 Much (Nähe Köln)<br>Telefon: 0049 2245 919 40 (Dienstag und Donnerstag 10-12 Uhr)<br>Fax: 0049 2245 91 94 10<br><a href="mailto:anfragen@psychotraumatologie.de">anfragen@psychotraumatologie.de</a><br><a href="http://psychotraumatologie.de" target="_blank">www.psychotraumatologie.de</a></p>
<p>1991 als gemeinnütziger Verein gegründet, ist das Deutsche Institut für Psychotraumatologie (DIPT) eine der ersten wissenschaftlich-therapeutischen Einrichtungen der Bundesrepublik Deutschland, die sich programmatisch der Erforschung, Psychotherapie und Prävention psychotraumatischer Störungen gewidmet hat. So konnte im Laufe der Zeit eine Sensibilisierung der Fachwelt und der Öffentlichkeit für Psychotraumatologie erreicht werden. In enger Kooperation mit dem Institut für Klinische Psychologie und Psychotherapie der Universität zu Köln unter der Leitung von Prof. Dr. Gottfried Fischer, wurde im Jahr 1995 im Rahmen des Kölner Opferhilfemodell-Projekts (KOM) die psychologische Beratungsstelle für Gewalt- und Unfallopfer ins Leben gerufen und seither systematisch ausgebaut.</p>',
                'order' => 0,
                'is_published' => 1
            ],
            [
                'name' => 'Zentrum für Trauma- und Konfliktmangement (ZTK)',
                'description' => '<p>Clemensstr. 5-7<br>50676 Köln<br><a href="mailto:info@ztk-koeln.de">info@ztk-koeln.de</a><br><a href="http://www.ztk-koeln.de" target="_blank" rel="noopener">www.ztk-koeln.de</a></p>
<p>Das Zentrum für Trauma- und Konfliktmanagement (ZTK) ist ein interdisziplinärer und qualifizierter Zusammenschluss von Fachleuten unterschiedlicher Berufsgruppen aus den Bereichen Psychologie, Psychotherapie, Psychiatrie, Sozialpädagogik und Rechtswesen. Die Mitarbeitenden sind seit vielen Jahren auf die vielfältigen Arbeitsbereiche der Psychotraumatologie und des Krisen- und Konfliktmanagements spezialisiert. Das ZTK arbeitet nach einem integrativen und bedarfsorientierten Ansatz, der aus den langjährigen Erfahrungen in den genannten Arbeitsbereichen resultiert und sich an aktuellen wissenschaftlichen Erkenntnissen und Forschungsergebnissen orientiert.<br>Das ZTK hat einen eigenen <a href="https://www.edigo-verlag.de/" target="_blank" class="underline">Verlag</a>. Der edigo Verlag ist ein unabhängiger, im Jahr 2020 gegründeter Sachbuchverlag, der aktuelle psychologische und gesellschaftspolitische Themen behandelt.<br>Im Alltag stoßen wir auf das Dilemma der verkürzten Botschaft: Informationszyklen werden schneller, Debatten sind geprägt von oberflächlicher Erregung, die Aufmerksamkeitsspanne wird kürzer – und das in hochpolitischen Zeiten. Der edigo Verlag möchte neue Einblicke geben und Hintergrundwissen vermitteln.</p>',
                'order' => 1,
                'is_published' => 1
            ],
            [
                'name' => 'Krisenintervention Schweiz',
                'description' => '<p>Neumarkt 4<br>8400 Winterthur<br>Telefon: 052 208 03 20<br><a href="mailto:info@kriseninterventionschweiz.ch">info@kriseninterventionschweiz.ch</a></p>
<p>Die Krisenintervention Schweiz, eine zertifizierte Ausbildungs- und Einsatzorganisation NNPN, bietet in herausfordernden Situationen Beratungen für Teams, Führungs- und Privatpersonen an – sowohl in Betrieben als auch im pädagogischen Bereich. Neben dem Beratungsangebot in Krisen- und Notsituationen, stellt die Krisenintervention Schweiz auch Aus- und Fortbildungen in praxisbezogener Notfall-Psychologie für Peers und Caregiver bereit. (Teilnehmenden, die bei der Krisenintervention Schweiz eine Peer-/Careausbildung absolviert haben, werden beim SIPT die Module „Grundkurs" und „Akute Traumatisierung" angerechnet.)</p>',
                'order' => 2,
                'is_published' => 1
            ],
            [
                'name' => 'Zentrum für interdisziplinäre Therapien (ZiT)',
                'description' => '<p>
Obere Laube 44<br>
78462 Konstanz<br>
Deutschland<br>
Telefon: 0049 7531 915501<br>
<a href="mailto:info@myoreflex.de">info@myoreflex.de</a><br><a href="https://www.myoreflex.de " target="_blank">www.myoreflex.de</a><br><a href="https://www.myoreflex.de/uebersichtsseite-praxen/zit-konstanz " target="_blank">www.myoreflex.de/uebersichtsseite-praxen/zit-konstanz</a></p>
</p>
<p>Im Mittelpunkt der Myoreflextherapie steht das Zentrum für interdisziplinäre Therapien in Konstanz (ZiT). In dieser Gemeinschaftspraxis finden sich die verschiedensten Therapieformen unter einem Dach: Von der Myoreflextherapie über westliche Hochschulmedizin bis zur traditionellen chinesischen Medizin, von der Klangschalenbehandlung bis zur Psychotherapie.<br>Eine der wichtigsten Säulen der Myoreflextherapie ist die produktive und vertrauensvolle Zusammenarbeit zwischen Patienten, Therapeuten, dem Umfeld sowie ein lebendiges Netzwerk von Bündnispartnern – zu denen auch das SIPT gehört.</p>',
                'order' => 3,
                'is_published' => 1
            ],
            [
                'name' => 'Swiss Campus - Internationales Institut für Gesundheit, Kommunikation und Entwicklung',
                'description' => '<p>
Mettlenstrasse 3<br>6363 Fürigen<br>
<a href="mailto:urs.gruber@swiss-campus.ch" target="_blank">urs.gruber@swiss-campus.ch</a>
</p>
<p>
Swiss Campus ist ein Unternehmen, das sich der Bildung, Beratung, Qualitätssicherung (Zertifizierung) und Forschung in den Bereichen Medizin, Gesundheit, Kommunikation und Entwicklung sowie einer übergeordneten Heilkultur widmet. Als An-Institut des DTMD Institut Supérieur de Formation Continue, bzw der DTMD Hochschule (mit Sitz in Luxemburg) lassen wir uns von den Inhalten des Brügge-Kopenhagen-Prozess der Europäischen Union leiten.<br>
Der Brügge-Kopenhagen-Prozess hat der beruflichen Bildung innerhalb der EU-Bildungskooperation einen neuen Stellenwert gegeben, so dass wir in der Lage sind, auch Personen aus der Berufsbildung ein akademisches Studium zu ermöglichen. Als akademisches Weiterbildungsinstitut haben wir im gesamten deutschsprachigen Raum qualifizierte Partner.
</p>',
                'order' => 4,
                'is_published' => 1
            ],
        ];

        foreach ($institutions as $institution) {
            PartnerInstitution::create($institution);
            $this->line('✓ Created: ' . $institution['name']);
        }

        $this->info('');
        $this->info('All partner institutions created successfully!');

        return 0;
    }
}
