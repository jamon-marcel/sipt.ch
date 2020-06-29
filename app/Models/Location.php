<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Location extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'name',
    'name_short',
    'street',
    'street_no',
    'zip',
    'city',
  ];
}