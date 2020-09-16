<?php
namespace App\Tasks;

class CourseEventReminder
{
  public function __invoke()
  {
    event(new \App\Events\CourseEventReminder());
  }
}