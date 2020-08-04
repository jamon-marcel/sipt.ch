<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
  protected $table = 'onboarding';
  
  protected $fillable = [
    'name', 'firstname', 'email', 'has_invitation', 'role'
  ];

}
