<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PartnerInstitution;

class PartnerInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'Deutsches Institut für Psychotraumatologie (DIPT)',
                'description' => '<p><strong>Standort:</strong> Much, Deutschland (nahe Köln)</p>
<p>Das Deutsche Institut für Psychotraumatologie wurde 1991 als gemeinnütziger Verein gegründet und widmet sich der Forschung, Psychotherapie und Prävention psychotraumatischer Störungen. Es betreibt eine psychologische Beratungsstelle für Opfer von Gewalt und Unfällen.</p>',
                'order' => 0,
                'is_published' => 1
            ],
            [
                'name' => 'Zentrum für Trauma- und Konfliktmanagement (ZTK)',
                'description' => '<p><strong>Standort:</strong> Köln, Deutschland</p>
<p>Das ZTK verfügt über ein multidisziplinäres Team aus den Bereichen Psychologie, Psychiatrie, Sozialarbeit und Recht. Seit 2020 betreibt das ZTK den edigo Verlag.</p>',
                'order' => 1,
                'is_published' => 1
            ],
            [
                'name' => 'Krisenintervention Schweiz',
                'description' => '<p><strong>Standort:</strong> Winterthur, Schweiz</p>
<p>Krisenintervention Schweiz ist eine zertifizierte Ausbildungs- und Einsatzorganisation, die Beratungen für Teams, Führungskräfte und Privatpersonen in Krisensituationen anbietet. Die Organisation bietet eine Anerkennung für Peer/Care-Ausbildungsmodule für die SIPT-Zertifizierung.</p>',
                'order' => 2,
                'is_published' => 1
            ],
            [
                'name' => 'Zentrum für interdisziplinäre Therapien (ZiT)',
                'description' => '<p><strong>Standort:</strong> Konstanz, Deutschland</p>
<p>Das ZiT integriert verschiedene Therapieansätze, darunter Myoreflextherapie und traditionelle chinesische Medizin.</p>',
                'order' => 3,
                'is_published' => 1
            ],
            [
                'name' => 'Swiss Campus',
                'description' => '<p><strong>Standort:</strong> Fürigen, Schweiz</p>
<p>Swiss Campus ist eine Institution mit Schwerpunkt auf Bildung und Forschung in den Bereichen Gesundheit, Kommunikation und Entwicklung. Die Institution ist mit DTMD-Institutionen in Luxemburg verbunden.</p>',
                'order' => 4,
                'is_published' => 1
            ],
        ];

        foreach ($institutions as $institution) {
            PartnerInstitution::create($institution);
        }
    }
}
