<?php
namespace App\Helpers;
use App\Models\CourseEventStudent;
use App\Models\SymposiumSubscriber;
use Illuminate\Support\Str;

class AppHelper
{
  public static function slug($str = NULL)
  {
    $slug = '';
    $slug = Str::slug(AppHelper::transliterate($str), '-');
    return $slug;
  }

  public static function nl2p($string = NULL)
  {
    $string = nl2br($string, false);
    return '<p>' . preg_replace('#(<br>[\r\n\s]+){2}#', '</p><p>', $string) . '</p>';
  }

  public static function transliterate($string = NULL)
  {
    $search = array(
      'ä', 'ö', 'ü', 'é', 'è', 'â', 'à', 'ç',
    );

    $replace = array(
      'ae', 'oe', 'ue', 'e', 'e', 'a', 'a', 'c',
    );
    return (string) str_replace($search, $replace, mb_strtolower($string, 'UTF-8'));
  }

  public static function number($amount)
  {
    return number_format(round($amount * 20) / 20, 2, '.', '');
  }

  public static function datesToString($data = NULL)
  {
    return $data->implode('date', '/');
  }

  public static function timesToString($data = NULL, $hasSpace = FALSE)
  {
    $start = $data->pluck('timeStart');
    $end   = $data->pluck('timeEnd');
   
    if (count($data) == 2)
    {
      $day1 = $start[0] . '–' . $end[0];
      $day2 = $start[1] . '–' . $end[1];
      return $day1 . '/' . $day2;
    }
    else if (count($start) == 1)
    {
      $day1 = $start[0] . '–' . $end[0];
      return $day1;
    }
    return null;
  }

  public static function tutorsToString($data, $filterDuplicates = FALSE)
  {
    $tutors = $data->pluck('tutor.fullName');

    echo '<!--';
    var_dump(collect($tutors)->unique()->values());
    echo '-->';

    if ($filterDuplicates)
    {
     return collect($tutors)->unique()->values()->first();
    }

    return collect($tutors)->implode('/');
  }

  public static function locationName($data, $showCity = FALSE)
  {
    $location = \App\Models\Location::find($data);

    if ($showCity)
    {
      return $location->name_short . ', ' . $location->city;
    }

    return $location->name_short;
  }

  public static function locationNameFull($data, $showCity = FALSE)
  {
    $location = \App\Models\Location::find($data);

    if ($showCity)
    {
      return $location->name . ', ' . $location->city;
    }

    return $location->name;
  }

  public static function locationMap($data)
  {
    $location = \App\Models\Location::find($data);
    return $location->maps_uri;
  }
}