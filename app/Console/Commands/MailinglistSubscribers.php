<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use Illuminate\Console\Command;

class MailinglistSubscribers extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mailinglist:subscribers
                          {mailinglist? : ID of the mailinglist, omit for an overview of all lists}
                          {--csv= : Write the addresses to this file instead of printing them}
                          {--include-unconfirmed : Also include subscribers who never confirmed}
                          {--include-unsubscribed : Also include subscribers who unsubscribed}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'List the subscribers of a mailinglist (overview of all lists if no list is given)';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle(): int
  {
    // No list given: show an overview of all lists with their subscriber counts
    if (!$this->argument('mailinglist'))
    {
      return $this->overview();
    }

    $mailinglist = Mailinglist::find($this->argument('mailinglist'));

    if (!$mailinglist)
    {
      $this->error('Mailinglist not found: ' . $this->argument('mailinglist'));
      return self::FAILURE;
    }

    $subscribers = $this->query()->where('mailinglist_id', $mailinglist->id)->orderBy('email')->get();

    $this->info($mailinglist->description . ' - ' . $subscribers->count() . ' subscriber(s)');

    if ($this->option('csv'))
    {
      return $this->writeCsv($subscribers, [$mailinglist]);
    }

    foreach($subscribers as $s)
    {
      $this->line($s->email . $this->status($s));
    }

    return self::SUCCESS;
  }

  /**
   * Show all lists with their subscriber counts
   *
   * @return int
   */
  protected function overview(): int
  {
    $mailinglists = Mailinglist::orderBy('order')->get();

    if ($this->option('csv'))
    {
      $subscribers = $this->query()->orderBy('email')->get();
      return $this->writeCsv($subscribers, $mailinglists);
    }

    $rows = [];
    foreach($mailinglists as $m)
    {
      $rows[] = [
        $m->id,
        $m->description,
        $m->public ? 'ja' : 'nein',
        $this->query()->where('mailinglist_id', $m->id)->count(),
      ];
    }

    $this->table(['ID', 'Liste', 'Öffentlich', 'Empfänger'], $rows);
    $this->newLine();
    $this->line('Eindeutige Adressen über alle Listen: ' . $this->query()->distinct('email')->count('email'));
    $this->line('Adressen einer Liste anzeigen: php artisan mailinglist:subscribers <ID>');

    return self::SUCCESS;
  }

  /**
   * Base query honouring the confirmation/unsubscribe options
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  protected function query()
  {
    $query = $this->option('include-unsubscribed')
      ? MailinglistSubscriber::withTrashed()
      : MailinglistSubscriber::query();

    if (!$this->option('include-unconfirmed'))
    {
      $query->where('is_confirmed', 1);
    }

    return $query;
  }

  /**
   * Write the subscribers to a csv file
   *
   * @param  \Illuminate\Support\Collection $subscribers
   * @param  \Illuminate\Support\Collection|array $mailinglists
   * @return int
   */
  protected function writeCsv($subscribers, $mailinglists): int
  {
    $path = $this->option('csv');
    $descriptions = collect($mailinglists)->keyBy('id');

    $handle = fopen($path, 'w');

    if (!$handle)
    {
      $this->error('Could not write to ' . $path);
      return self::FAILURE;
    }

    // BOM, so Excel opens the umlauts correctly
    fwrite($handle, "\xEF\xBB\xBF");
    fputcsv($handle, ['E-Mail', 'Liste', 'Status', 'Angemeldet am'], ';');

    foreach($subscribers as $s)
    {
      fputcsv($handle, [
        $s->email,
        $descriptions[$s->mailinglist_id]->description ?? $s->mailinglist_id,
        $s->trashed() ? 'abgemeldet' : ($s->is_confirmed ? 'aktiv' : 'unbestätigt'),
        $s->created_at ? $s->created_at->format('d.m.Y') : '',
      ], ';');
    }

    fclose($handle);

    $this->info($subscribers->count() . ' Adresse(n) geschrieben nach ' . $path);

    return self::SUCCESS;
  }

  /**
   * Status suffix for the console output
   *
   * @param  MailinglistSubscriber $subscriber
   * @return string
   */
  protected function status($subscriber): string
  {
    if ($subscriber->trashed())
    {
      return ' (abgemeldet)';
    }

    return $subscriber->is_confirmed ? '' : ' (unbestätigt)';
  }
}
