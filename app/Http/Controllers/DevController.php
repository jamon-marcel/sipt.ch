<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\SymposiumSubscriber;
use App\Models\ImportantNoticeSubscriber;
use App\Models\AdvertismentSubscriber;
use App\Models\NewsletterSubscriber;
use App\Models\MessageLog;

class DevController extends Controller
{
  public function __construct(
    User $user, 
    SymposiumSubscriber $symposiumSubscriber,
    ImportantNoticeSubscriber $importantNoticeSubscriber,
    AdvertismentSubscriber $advertismentSubscriber,
    NewsletterSubscriber $newsletterSubscriber,
    MessageLog $messageLog
  )
  {
    $this->user = $user; 
    $this->symposiumSubscriber = $symposiumSubscriber; 
    $this->importantNoticeSubscriber = $importantNoticeSubscriber; 
    $this->advertismentSubscriber = $advertismentSubscriber; 
    $this->newsletterSubscriber = $newsletterSubscriber;
    $this->messageLog = $messageLog;
  }

  public function importUser()
  {
    $users = User::get();
    foreach($users as $user)
    {
      $existing = ImportantNoticeSubscriber::where('email', $user->email)->get()->first();
      if (!$existing)
      {
        ImportantNoticeSubscriber::create([
          'email' => $user->email,
          'is_done' => 1,
          'is_failed' => 0
        ]);
      }
    }
  }

  public function maskUser()
  {
    $users = [
      $this->user->get(),
      $this->symposiumSubscriber->get(),
      $this->importantNoticeSubscriber->get(),
      $this->advertismentSubscriber->get(),
      $this->newsletterSubscriber->get(),
      $this->messageLog->get()
    ];

    foreach($users as $user)
    {
      foreach($user as $u)
      {
        if ($u->email != 'm@marceli.to')
        {
          $u->email = \Str::random(24) . '@test.sipt.ch';
          $u->save();
        }
      }
    }
  }
}
