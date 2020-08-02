<?php
namespace App\Tasks;

class CourseEventBills
{
  public function __invoke()
  {
    event(new \App\Events\CourseEventBill(TRUE));
  }
}