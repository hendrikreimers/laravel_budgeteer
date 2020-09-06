<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $self
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $self, User $user)
    {
        if ( ($user->id == Auth::user()->id) || ($self->roles()->first()->user_view) ) {
            return true;
        } else return false;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $self
     * @return mixed
     */
    public function list(User $self) {
        return $self->roles()->first()->user_list;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $self
     * @return mixed
     */
    public function newUser(User $self) {
        return $self->roles()->first()->user_create;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function create(User $self)
    {
        return $self->roles()->first()->role_create;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $self, User $user)
    {
        return $self->roles()->first()->role_update;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $self
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $self, User $user)
    {
        // you didn't delete yourself
        if ( $self->id == $user->id ) return false;

        return $self->roles()->first()->role_delete;
    }
}
