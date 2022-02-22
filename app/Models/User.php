<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
  use Notifiable;
  use SoftDeletes;
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'email', 'email_verified_at', 'password', 'role'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'role'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * Role helper for admins
   */

  public function isAdmin()
  {
    return $this->role == 'admin' ? TRUE : FALSE;
  }

  /**
   * Role helper for students
   */

  public function isStudent()
  {
    return $this->role == 'student' ? TRUE : FALSE;
  }

  /**
   * Role helper for tutors
   */

  public function isTutor()
  {
    return $this->role == 'tutor' ? TRUE : FALSE;
  }

  public function tutor()
	{
    return $this->hasOne('App\Models\Tutor', 'user_id', 'id');
  }
  
  public function student()
	{
    return $this->hasOne('App\Models\Student', 'user_id', 'id');
  }
  
  public function administrator()
	{
    return $this->hasOne('App\Models\Administrator', 'user_id', 'id');
  }
}
