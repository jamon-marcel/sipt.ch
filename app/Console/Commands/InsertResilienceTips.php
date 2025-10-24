<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ResilienceTip;
use Illuminate\Support\Facades\Storage;

class InsertResilienceTips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resilience-tips:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert default resilience tips into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Inserting resilience tips...');

        $tips = [
            [
                'title' => 'Aufbau-Tipp Nr. 13 / Mai 2025',
                'subtitle' => 'Eine Schweizer Exklusivität: die Grengjer-Tulpe',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_13.pdf',
                'order' => 0,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 12 / November 2024',
                'subtitle' => 'Die Singschwäne und ihr magisches Spektakel',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_12.pdf',
                'order' => 1,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 11 / Mai 2024',
                'subtitle' => 'Schaurig schön, übers Moor zu wandern',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_11.pdf',
                'order' => 2,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 10 / Dezember 2023',
                'subtitle' => 'Eulenhäuser und Stadtumbau am Rhein',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderungg',
                'file' => 'sipt-aufbau_10.pdf',
                'order' => 3,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 9 / Mai 2023',
                'subtitle' => 'Eine ausgezeichnete Landschaft',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_09.pdf',
                'order' => 4,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 8 / Dezember 2022',
                'subtitle' => 'Vom barocken Kleinstort zum barocken Spektakel',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_08.pdf',
                'order' => 5,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 7 / Mai 2022',
                'subtitle' => 'Die Planstadt und das Blumendorf im Klettgau',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_07.pdf',
                'order' => 6,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 6 / Dezember 2021',
                'subtitle' => 'Im Murg-Auen-Park fühlen sich Mensch, Biber & Co. wohl',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_06.pdf',
                'order' => 7,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 5 / Mai 2021',
                'subtitle' => 'Wie aus Abfall ein Paradies entsteht',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_05.pdf',
                'order' => 8,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 4 / Januar 2021',
                'subtitle' => 'Eine Waldkathedrale mit Aussicht',
                'description' => 'Ein Ausflug im Winter, Frühling, Sommer und Herbst',
                'file' => 'sipt-aufbau_04.pdf',
                'order' => 9,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 3 / Januar 2020',
                'subtitle' => 'Tosende Wasser und die grosse Ruhe',
                'description' => 'Eine Winter – Frühlings – Sommer – Herbst – Wanderung',
                'file' => 'sipt-aufbau_03.pdf',
                'order' => 10,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 2 / Juli 2019',
                'subtitle' => 'Von Revolutionärinnnen & Nonnen, Kunst & Natur',
                'description' => 'Sommer Wanderung',
                'file' => 'sipt-aufbau_02.pdf',
                'order' => 11,
                'is_published' => 1
            ],
            [
                'title' => 'Aufbau-Tipp Nr. 1 / Januar 2019',
                'subtitle' => '„Bachtel du Riese, breit hin gelagerter nebelumwallter Götterberg"',
                'description' => 'Winter Wanderung',
                'file' => 'sipt-aufbau_01.pdf',
                'order' => 12,
                'is_published' => 1
            ],
        ];

        foreach ($tips as $tip) {
            // Copy file from downloads/ to uploads/ if it exists
            if ($tip['file']) {
                $sourceFile = 'downloads/' . $tip['file'];
                $destFile = 'uploads/' . $tip['file'];

                if (Storage::disk('public')->exists($sourceFile)) {
                    if (!Storage::disk('public')->exists($destFile)) {
                        Storage::disk('public')->copy($sourceFile, $destFile);
                        $this->line('  → Copied file: ' . $tip['file']);
                    } else {
                        $this->line('  → File already exists: ' . $tip['file']);
                    }
                } else {
                    $this->warn('  ⚠ File not found: ' . $sourceFile);
                }
            }

            ResilienceTip::create($tip);
            $this->line('✓ Created: ' . $tip['title']);
        }

        $this->info('');
        $this->info('All resilience tips created successfully!');

        return 0;
    }
}
