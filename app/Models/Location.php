<?php
Namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Location extends Model
{
  protected $fillable = [
    'name',
    'name_short',
    'street',
    'street_no',
    'zip',
    'city',
  ];
}