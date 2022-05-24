<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\SymposiumSubscriber;
use App\Models\ImportantNoticeSubscriber;
use App\Models\AdvertismentSubscriber;
use App\Models\NewsletterSubscriber;

class DevController extends Controller
{
  public function __construct(
    User $user, 
    SymposiumSubscriber $symposiumSubscriber,
    ImportantNoticeSubscriber $importantNoticeSubscriber,
    AdvertismentSubscriber $advertismentSubscriber,
    NewsletterSubscriber $newsletterSubscriber
  )
  {
    $this->user = $user; 
    $this->symposiumSubscriber = $symposiumSubscriber; 
    $this->importantNoticeSubscriber = $importantNoticeSubscriber; 
    $this->advertismentSubscriber = $advertismentSubscriber; 
    $this->newsletterSubscriber = $newsletterSubscriber; 

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
}
