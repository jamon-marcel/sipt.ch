<?php
namespace App\Tasks;

class SymposiumBills
{
  public function __invoke()
  {
    event(new \App\Events\SymposiumBill());
  }
}