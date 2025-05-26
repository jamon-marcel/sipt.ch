<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\SymposiumSubscriber;
// ImportantNoticeSubscriber model has been removed
// AdvertismentSubscriber model has been removed
use App\Models\NewsletterSubscriber;
use App\Models\MessageLog;

class DevController extends Controller
{
  public function __construct(
    User $user, 
    SymposiumSubscriber $symposiumSubscriber,
    // ImportantNoticeSubscriber model has been removed
    // AdvertismentSubscriber model has been removed,
    NewsletterSubscriber $newsletterSubscriber,
    MessageLog $messageLog
  )
  {
    $this->user = $user; 
    $this->symposiumSubscriber = $symposiumSubscriber; 
    // ImportantNoticeSubscriber model has been removed
    // AdvertismentSubscriber model has been removed
    $this->newsletterSubscriber = $newsletterSubscriber;
    $this->messageLog = $messageLog;
  }

  public function importUser()
  {
    // Method disabled as ImportantNoticeSubscriber model has been removed
    return response()->json(['message' => 'This functionality has been removed']);
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
