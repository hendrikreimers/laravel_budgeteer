<?php

namespace App\Policies;

use App\User;
use App\Limit;
use Illuminate\Auth\Access\HandlesAuthorization;

class LimitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the limit.
     *
     * @param  \App\User  $self
     * @param  \App\Limit  $limit
     * @return mixed
     */
    public function view(User $self, Limit $limit)
    {
        return ( ($self->roles()->first()->limit_view) && ($self->id == $limit->user_id) ) ? true : false;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $self
     * @return mixed
     */
    public function list(User $self) {
        return $self->roles()->first()->limit_list;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function newLimit(User $self)
    {
        return $self->roles()->first()->limit_create;
    }

    /**
     * Determine whether the user can create limits.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function create(User $self)
    {
        return $self->roles()->first()->limit_create;
    }

    /**
     * Determine whether the user can update the limit.
     *
     * @param  \App\User  $self
     * @param  \App\Limit  $limit
     * @return mixed
     */
    public function update(User $self, Limit $limit)
    {
        return ( ($self->roles()->first()->limit_update) && ($self->id == $limit->user_id) ) ? true : false;
    }

    /**
     * Determine whether the user can delete the limit.
     *
     * @param  \App\User  $self
     * @param  \App\Limit  $limit
     * @return mixed
     */
    public function delete(User $self, Limit $limit)
    {
        return ( ($self->roles()->first()->limit_delete) && ($self->id == $limit->user_id) ) ? true : false;
    }
}
