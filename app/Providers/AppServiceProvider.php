<?php

namespace App\Providers;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\Training;
use App\Observers\CourseObserver;
use App\Observers\CourseEventObserver;
use App\Observers\TrainingObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    setLocale(LC_ALL, 'de_CH.UTF-8');
    
    CourseEvent::observe(CourseEventObserver::class);
    Course::observe(CourseObserver::class);
    Training::observe(TrainingObserver::class);
  }
}
