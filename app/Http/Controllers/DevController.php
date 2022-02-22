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

  public function users()
  {
    $students = Student::get();
    $students_user = Student::with('user')->get();
    dd($students[67], $students_user[800]);
  }

  // public function maskUser()
  // {

  //   // Users
  //   $users = $this->user->get();
  //   foreach($users as $u)
  //   {
  //     if ($u->role != 'admin')
  //     {
  //       $rand_user = \Str::random(8);
  //       $u->email = strtolower($rand_user) . '@jamondigital.ch';
  //       $u->save();
  //     }
  //   }

  //   // Symposium subscribers
  //   $symposiumSubscriber = $this->symposiumSubscriber->get();
  //   foreach($symposiumSubscriber as $u)
  //   {
  //     $rand_user = \Str::random(8);
  //     $u->email = strtolower($rand_user) . '@jamondigital.ch';
  //     $u->save();
  //   }

  //   // Important notice subscribers
  //   $importantNoticeSubscribers = $this->importantNoticeSubscriber->get();
  //   foreach($importantNoticeSubscribers as $u)
  //   {
  //     $rand_user = \Str::random(8);
  //     $u->email = strtolower($rand_user) . '@jamondigital.ch';
  //     $u->save();
  //   }

  //   // Advertisement subscribers
  //   $advertismentSubscribers = $this->advertismentSubscriber->get();
  //   foreach($advertismentSubscribers as $u)
  //   {
  //     $rand_user = \Str::random(8);
  //     $u->email = strtolower($rand_user) . '@jamondigital.ch';
  //     $u->save();
  //   }

  //   // Newsletter subscribers
  //   $newsletterSubscribers = $this->newsletterSubscriber->get();
  //   foreach($newsletterSubscribers as $u)
  //   {
  //     $rand_user = \Str::random(8);
  //     $u->email = strtolower($rand_user) . '@jamondigital.ch';
  //     $u->save();
  //   }

  // }
}
