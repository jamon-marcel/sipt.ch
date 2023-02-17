<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailinglistSubscriberLog extends Model
{
	protected $fillable = [
    'id',
    'email',
    'action',
    'is_user',
  ];    

}
