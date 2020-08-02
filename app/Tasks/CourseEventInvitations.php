<?php
namespace App\Tasks;

class CourseEventInvitations
{
  public function __invoke()
  {
    event(new \App\Events\CourseEventInvitation());
  }
}