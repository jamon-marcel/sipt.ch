<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SymposiumSubscriber;

class DevController extends Controller
{
  public function __construct(User $user, SymposiumSubscriber $subscriber)
  {
    $this->user = $user; 
    $this->subscriber = $subscriber;  
  }

  public function invite()
  {
    // event(new \App\Events\CourseEventInvitation());
  }

  public function bills()
  {
    // event(new \App\Events\SymposiumBill());
  }

  public function maskUser()
  {
    // $subscribers = $this->subscriber->get();
    // foreach($subscribers as $u)
    // {
    //   $rand_user = \Str::random(8);
    //   $u->email = strtolower($rand_user) . '@jamondigital.ch';
    //   $u->save();
    // }

    // $users = $this->user->get();
    // foreach($users as $u)
    // {
    //   if ($u->role != 'admin')
    //   {
    //     $rand_user = \Str::random(8);
    //     $u->email = strtolower($rand_user) . '@jamondigital.ch';
    //     $u->save();
    //   }
    // }
  }
}
