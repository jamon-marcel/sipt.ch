<?php
namespace App\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SymposiumBill
{
  use Dispatchable, SerializesModels;
  
  /**
   * Create a new event instance.
   * 
   * @return void
   */
  public function __construct()
  {
  }
}
