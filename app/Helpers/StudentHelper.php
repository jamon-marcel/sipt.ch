<?php
namespace App\Helpers;
use App\Models\Student;
use App\Models\SymposiumSubscriber;

class StudentHelper
{
  public static function getNumber()
  {
    $max_student   = Student::withTrashed()->max('number');
    $max_symposium = SymposiumSubscriber::withTrashed()->max('number');
    $number = $max_student > $max_symposium ? $max_student + 1 : $max_symposium + 1;
    return $number;
  }
}