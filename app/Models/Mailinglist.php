<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Mailinglist extends Model
{
  protected $fillable = [
    'description',
    'order'
	];
}
