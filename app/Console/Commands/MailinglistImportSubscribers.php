<?php

namespace App\Console\Commands;

use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class MailinglistImportSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailinglist:import-subscribers
                            {csv_file : Path to the CSV file with email addresses}
                            {mailinglist_id? : The ID of the mailing list (optional, will prompt if not provided)}
                            {--confirmed=1 : Set subscribers as confirmed (1) or unconfirmed (0)}
                            {--skip-duplicates : Skip existing email addresses instead of updating them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import subscribers from a CSV file to a mailing list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvFile = $this->argument('csv_file');
        $mailinglistId = $this->argument('mailinglist_id');
        $isConfirmed = $this->option('confirmed');
        $skipDuplicates = $this->option('skip-duplicates');

        // If mailing list ID not provided, show selection menu
        if (!$mailinglistId) {
            $mailinglists = Mailinglist::orderBy('order')->orderBy('short_description')->get();

            if ($mailinglists->isEmpty()) {
                $this->error('No mailing lists found. Please create one first.');
                return Command::FAILURE;
            }

            $choices = [];
            foreach ($mailinglists as $list) {
                $publicStatus = $list->public ? 'Public' : 'Private';
                $choices[$list->id] = "{$list->short_description} ({$publicStatus})";
            }

            $mailinglistId = $this->choice(
                'Select a mailing list',
                $choices
            );
        }

        // Check if mailing list exists
        $mailinglist = Mailinglist::find($mailinglistId);
        if (!$mailinglist) {
            $this->error("Mailing list with ID {$mailinglistId} not found.");
            return Command::FAILURE;
        }

        // Check if file exists
        if (!file_exists($csvFile)) {
            $this->error("CSV file not found: {$csvFile}");
            return Command::FAILURE;
        }

        $this->info("Importing subscribers to mailing list: {$mailinglist->short_description}");

        $emails = [];
        $lineNumber = 0;

        // Read CSV file
        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $lineNumber++;

                // Skip empty lines
                if (empty($data[0])) {
                    continue;
                }

                $email = trim($data[0]);

                // Validate email
                $validator = Validator::make(['email' => $email], [
                    'email' => 'required|email'
                ]);

                if ($validator->fails()) {
                    $this->warn("Line {$lineNumber}: Invalid email '{$email}' - skipping");
                    continue;
                }

                $emails[] = $email;
            }
            fclose($handle);
        }

        if (empty($emails)) {
            $this->error('No valid email addresses found in CSV file.');
            return Command::FAILURE;
        }

        $this->info("Found " . count($emails) . " valid email addresses.");

        $bar = $this->output->createProgressBar(count($emails));
        $bar->start();

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($emails as $email) {
            $existing = MailinglistSubscriber::where('mailinglist_id', $mailinglistId)
                ->where('email', $email)
                ->first();

            if ($existing) {
                if ($skipDuplicates) {
                    $skipped++;
                } else {
                    $existing->is_confirmed = $isConfirmed;
                    $existing->hash = md5($email);
                    $existing->save();
                    $updated++;
                }
            } else {
                MailinglistSubscriber::create([
                    'mailinglist_id' => $mailinglistId,
                    'email' => $email,
                    'hash' => md5($email),
                    'is_confirmed' => $isConfirmed,
                ]);
                $imported++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Import completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['New subscribers', $imported],
                ['Updated subscribers', $updated],
                ['Skipped duplicates', $skipped],
                ['Total processed', count($emails)],
            ]
        );

        return Command::SUCCESS;
    }
}
