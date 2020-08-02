<?php
namespace App\Helpers;
use App\Models\CourseEventStudent;
use App\Models\SymposiumSubscriber;

class BookingHelper
{
  public static function getNumber()
  {
    $max_events    = CourseEventStudent::withTrashed()->max('booking_number');
    $max_symposium = SymposiumSubscriber::withTrashed()->max('booking_number');

    $max_booking_number = $max_events > $max_symposium ? $max_events + 1 : $max_symposium + 1;
    $booking_number     = ($max_booking_number > \Config::get('sipt.min_booking_number')) ? $max_booking_number : \Config::get('sipt.min_booking_number');
    return str_pad($booking_number, 6, "0", STR_PAD_LEFT);
  }
}