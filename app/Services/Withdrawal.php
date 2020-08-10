<?php
namespace App\Services;
use Illuminate\Support\Carbon;

class Withdrawal
{
  public function __construct()
  {
  }

  public function getCharges($courseEventDate)
  {
    $days    = $this->getDiffInDays($courseEventDate);
    $penalty = $this->getPenalty($days);
    return $penalty;
  }

  public function getSymposiumCharges()
  {
    $deadline = strtotime('10.09.2020');
    $today = time();

    if ($today <= $deadline)
    {
      return 'partial';
    }
    return 'full';
  }

  /**
   * Get difference between today and a second date in days
   * 
   * @param Date $date
   * @return Integer days
   */
  private function getDiffInDays($date)
  {
    return Carbon::parse($date)->diffInDays(Carbon::now());
  }

  /**
   * Get penalty
   * 
   * @param Integer $days
   * @return String $penalty
   *  
   */
  private function getPenalty($days)
  {
    $penalty = '';
    switch($days)
    {
      case $days < 14:
        $penalty = 100;
      break;

      case $days < 28:
        $penalty = 50;
      break;

      case $days < 56:
        $penalty = 25;
      break;

      default:
        $penalty = 0;
      break;
    }
    return $penalty;
  }
}