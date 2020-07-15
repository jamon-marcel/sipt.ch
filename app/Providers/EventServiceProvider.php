<?php

namespace App\Providers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [

    Registered::class => [
      SendEmailVerificationNotification::class,
    ],

    'App\Events\StudentRegistered' => [
      'App\Listeners\SendEmailVerification',
    ],

    'App\Events\SymposiumConfirmSubscription' => [
      'App\Listeners\SymposiumCreateInvoice',
      'App\Listeners\SymposiumNotifySubscriber',
    ],

    'App\Events\CourseEventParticipantsList' => [
      'App\Listeners\CourseEventCreateParticipantsList',
    ],

    'App\Events\CourseList' => [
      'App\Listeners\CourseCreateList',
    ],

    'App\Events\CourseEventBooked' => [
      'App\Listeners\CourseEventStudentConfirm',
    ],

    'App\Events\CourseEventCancelled' => [
      'App\Listeners\CourseEventStudentCancel',
    ],

    'App\Events\StudentInvoice' => [
      'App\Listeners\CreateSendStudentInvoice',
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    parent::boot();
  }
}
