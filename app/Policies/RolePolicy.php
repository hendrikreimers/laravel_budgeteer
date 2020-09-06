<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function view(User $self, Role $role)
    {
        return $self->roles()->first()->role_view;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $user
     * @return mixed
     */
    public function list(User $self) {
        return $self->roles()->first()->role_list;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function newRole(User $self)
    {
        return $self->roles()->first()->role_create;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function create(User $self)
    {
        return $self->roles()->first()->role_create;
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $self
     * @param  \App\Role  $role
     * @return mixed
     */
    public function update(User $self, Role $role)
    {
        if ( $role->read_only ) return false;
        return $self->roles()->first()->role_update;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $self
     * @param  \App\Role  $role
     * @return mixed
     */
    public function delete(User $self, Role $role)
    {
        if ( $role->read_only ) return false;
        return $self->roles()->first()->role_delete;
    }
}
