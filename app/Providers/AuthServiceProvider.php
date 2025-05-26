<?php
namespace App\Providers;
use App\Policies\StudentPolicy;
use App\Policies\TutorPolicy;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    Student::class => StudentPolicy::class,
    Tutor::class => TutorPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    // The registerPolicies method is now automatically called by the framework
  }
}
