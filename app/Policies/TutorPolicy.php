<?php

namespace App\Policies;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TutorPolicy
{
  use HandlesAuthorization;

  public function before($user, $ability)
  {
    if ($user->isAdmin())
    {
      return true;
    }
  }

  /**
   * Determine whether the user can view any models.
   *
   * @param \App\Models\User $user
   * @return mixed
   */
  public function viewAny(User $user, Tutor $tutor)
  {
    return $user->id === $tutor->user_id
           ? Response::allow() 
           : Response::deny('Access denied');
  }

  /**
   * Determine whether the user can view the model.
   *
   * @param  \App\Models\User $user
   * @param  \App\Models\Tutor $tutor
   * @return mixed
   */
  public function view(User $user, Tutor $tutor)
  {
    return $user->id === $tutor->user_id
           ? Response::allow() 
           : Response::deny('Access denied');
  }

  /**
   * Determine whether the user can create models.
   *
   * @param  \App\Models\User  $user
   * @return mixed
   */
  public function create(User $user)
  {
    //
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\Tutor  $tutor
   * @return \Illuminate\Auth\Access\Response
   */
  public function update(User $user, Tutor $tutor)
  {
    return $user->id === $tutor->user_id 
           ? Response::allow() 
           : Response::deny('Access denied');
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\Tutor  $tutor
   * @return mixed
   */
  public function delete(User $user, Tutor $tutor)
  {
    //
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\Tutor  $tutor
   * @return mixed
   */
  public function restore(User $user, Tutor $tutor)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\Tutor  $tutor
   * @return mixed
   */
  public function forceDelete(User $user, Tutor $tutor)
  {
    //
  }

}
