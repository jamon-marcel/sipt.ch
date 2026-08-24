<?php
namespace App\Console\Commands;
use App\Models\AnniversaryRegistration;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use Illuminate\Console\Command;

class MailinglistImportAnniversary extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mailinglist:import-anniversary
                          {mailinglist? : ID of the target mailinglist}
                          {--dry-run : Only report what would be imported, write nothing}
                          {--restore-unsubscribed : Also reactivate addresses that unsubscribed from this list before}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Import the email addresses of all anniversary (20 Jahre SIPT) participants into a mailinglist';

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
    $mailinglist = $this->resolveMailinglist();

    if (!$mailinglist)
    {
      $this->error('No mailinglist selected.');
      return self::FAILURE;
    }

    $dryRun = $this->option('dry-run');

    $this->info('Target mailinglist: ' . $mailinglist->description . ' (' . $mailinglist->id . ')');
    if ($dryRun)
    {
      $this->warn('Dry run - nothing will be written.');
    }

    // Collect valid, unique addresses of all registrations that were not cancelled
    $registrations = AnniversaryRegistration::where('is_cancelled', 0)->orderBy('created_at')->get();

    $emails = [];
    $invalid = [];

    foreach($registrations as $r)
    {
      $email = strtolower(trim((string) $r->email));

      if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $invalid[] = $r->fullName . ' (' . $r->email . ')';
        continue;
      }

      $emails[$email] = $email;
    }

    $this->line('Registrations (not cancelled): ' . $registrations->count());
    $this->line('Unique valid addresses: ' . count($emails));

    if ($invalid)
    {
      $this->warn('Invalid or missing addresses (skipped): ' . count($invalid));
      foreach($invalid as $i)
      {
        $this->line('  - ' . $i);
      }
    }

    $created = 0;
    $activated = 0;
    $unchanged = 0;
    $unsubscribed = [];

    foreach($emails as $email)
    {
      $subscriber = MailinglistSubscriber::withTrashed()
        ->where('mailinglist_id', $mailinglist->id)
        ->where('email', $email)
        ->first();

      // Address is already on the list
      if ($subscriber)
      {
        // Respect a previous unsubscribe unless explicitly told otherwise
        if ($subscriber->trashed() && !$this->option('restore-unsubscribed'))
        {
          $unsubscribed[] = $email;
          continue;
        }

        if ($subscriber->trashed() || !$subscriber->is_confirmed)
        {
          if (!$dryRun)
          {
            $subscriber->deleted_at = NULL;
            $subscriber->is_confirmed = 1;
            $subscriber->hash = md5($email);
            $subscriber->save();
          }
          $activated++;
          continue;
        }

        $unchanged++;
        continue;
      }

      // New subscriber, confirmed right away - the addresses come from the
      // registration form, so there is no double opt-in to run through
      if (!$dryRun)
      {
        MailinglistSubscriber::create([
          'id' => \Str::uuid(),
          'mailinglist_id' => $mailinglist->id,
          'email' => $email,
          'hash' => md5($email),
          'is_confirmed' => 1,
        ]);
      }
      $created++;
    }

    if ($unsubscribed)
    {
      $this->warn('Previously unsubscribed (skipped, use --restore-unsubscribed to include): ' . count($unsubscribed));
      foreach($unsubscribed as $u)
      {
        $this->line('  - ' . $u);
      }
    }

    $this->newLine();
    $this->table(
      ['Added', 'Reactivated', 'Already active', 'Total on list'],
      [[
        $created,
        $activated,
        $unchanged,
        $dryRun
          ? $created + $activated + $unchanged
          : MailinglistSubscriber::active()->where('mailinglist_id', $mailinglist->id)->count()
      ]]
    );

    $this->info($dryRun ? 'Dry run finished.' : 'Import finished.');

    return self::SUCCESS;
  }

  /**
   * Get the mailinglist from the argument or ask for it
   *
   * @return Mailinglist|null
   */
  protected function resolveMailinglist()
  {
    if ($this->argument('mailinglist'))
    {
      return Mailinglist::find($this->argument('mailinglist'));
    }

    $mailinglists = Mailinglist::orderBy('order')->get();

    if ($mailinglists->isEmpty())
    {
      return NULL;
    }

    $description = $this->choice('Which mailinglist?', $mailinglists->pluck('description')->toArray());

    return $mailinglists->where('description', $description)->first();
  }
}
