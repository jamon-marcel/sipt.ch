<?php

namespace App\Console\Commands;

use App\Models\Mailinglist;
use Illuminate\Console\Command;

class MailinglistCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailinglist:create
                            {--short_description= : Short description of the mailing list}
                            {--description= : Full description of the mailing list}
                            {--order=-1 : Order/position of the mailing list}
                            {--public=0 : Whether the mailing list is public (1) or private (0)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new mailing list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $shortDescription = $this->option('short_description') ?: $this->ask('Enter a short description for the mailing list');
        $description = $this->option('description') ?: $this->ask('Enter a full description for the mailing list');
        $order = $this->option('order');
        $public = $this->option('public');

        if (!$shortDescription) {
            $this->error('Short description is required.');
            return Command::FAILURE;
        }

        $mailinglist = Mailinglist::create([
            'short_description' => $shortDescription,
            'description' => $description,
            'order' => $order,
            'public' => $public,
        ]);

        $this->info("Mailing list created successfully!");
        $this->table(
            ['ID', 'Short Description', 'Description', 'Order', 'Public'],
            [[$mailinglist->id, $mailinglist->short_description, $mailinglist->description, $mailinglist->order, $mailinglist->public ? 'Yes' : 'No']]
        );

        return Command::SUCCESS;
    }
}
