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

    'App\Events\SymposiumSubscription' => [
      'App\Listeners\SymposiumConfirmSubscription',
    ],

    'App\Events\SymposiumCancelled' => [
      'App\Listeners\SymposiumCancelSubscription',
    ],

    'App\Events\SymposiumBill' => [
      'App\Listeners\SymposiumCreateSendBill',
    ],

    'App\Events\CourseEventBooked' => [
      'App\Listeners\CourseEventConfirm',
    ],

    'App\Events\CourseEventCancelled' => [
      'App\Listeners\CourseEventCancel',
    ],

    'App\Events\CourseEventCancelledWithPenalty' => [
      'App\Listeners\CourseEventCancelWithPenalty',
    ],

    'App\Events\CourseEventBill' => [
      'App\Listeners\CourseEventCreateSendBill',
    ],

    'App\Events\CourseEventInvitation' => [
      'App\Listeners\CourseEventCreateSendInvitation',
    ],

    'App\Events\InvoiceReminder' => [
      'App\Listeners\InvoiceCreateSendReminder',
    ],

    'App\Events\CourseEventCancelledByAdministrator' => [
      'App\Listeners\CourseEventCancelByAdministrator',
    ],

    'App\Events\CourseEventClosed' => [
      'App\Listeners\CourseEventClose',
    ],

    'App\Events\CourseEventParticipantsChanged' => [
      'App\Listeners\CourseEventCheckMaxParticipants',
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
