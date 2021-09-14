<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class ImportantNoticeSubscriber extends Model
{
  use SoftDeletes;
  
	protected $fillable = [
    'email',
    'is_done',
    'is_failed'
	];
}
