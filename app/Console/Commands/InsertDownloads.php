<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class InsertDownloads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloads:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert default downloads into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Inserting downloads...');

        $downloads = [
            [
                'title' => 'Vorträge «Jubiläums-Fachtagung — 15 Jahre SIPT»',
                'file' => 'sipt-fachtagung-vortraege.zip',
                'order' => 0,
                'is_published' => 1
            ],
            [
                'title' => 'Bildungsangebot für BeraterInnen',
                'file' => 'sipt-bildungsangebot-fuer-beraterinnen-02-2024.pdf',
                'order' => 1,
                'is_published' => 1
            ],
            [
                'title' => 'Bildungsangebot für PädagogInnen',
                'file' => 'sipt-bildungsangebot-fuer-paedagoginnen-2024.pdf',
                'order' => 2,
                'is_published' => 1
            ],
            [
                'title' => 'Bildungsangebot für PsychotherapeutInnen',
                'file' => 'sipt-bildungsangebot-fuer-psychotherapeutinnen-2024.pdf',
                'order' => 3,
                'is_published' => 1
            ],
            [
                'title' => 'Lageplan SIPT',
                'file' => 'sipt-lageplan.pdf',
                'order' => 4,
                'is_published' => 1
            ],
            [
                'title' => 'Kursbeurteilung',
                'file' => 'sipt-kursbeurteilung.pdf',
                'order' => 5,
                'is_published' => 1
            ],
            [
                'title' => 'Anmeldung CAS',
                'file' => 'sipt-anmeldung-zertifikatsstudium-CAS-2025.pdf',
                'order' => 6,
                'is_published' => 1
            ],
        ];

        foreach ($downloads as $download) {
            // Copy file from downloads/ to uploads/ if it exists
            $sourceFile = 'downloads/' . $download['file'];
            $destFile = 'uploads/' . $download['file'];

            if (Storage::disk('public')->exists($sourceFile)) {
                if (!Storage::disk('public')->exists($destFile)) {
                    Storage::disk('public')->copy($sourceFile, $destFile);
                    $this->line('  → Copied file: ' . $download['file']);
                } else {
                    $this->line('  → File already exists: ' . $download['file']);
                }
            } else {
                $this->warn('  ⚠ File not found: ' . $sourceFile);
            }

            Download::create($download);
            $this->line('✓ Created: ' . $download['title']);
        }

        $this->info('');
        $this->info('All downloads created successfully!');

        return 0;
    }
}
