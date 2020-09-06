<?php

namespace App\Policies;

use App\User;
use App\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the account.
     *
     * @param  \App\User  $self
     * @param  \App\Subject $subject
     * @return mixed
     */
    public function view(User $self, Subject $subject)
    {
        if ( ($self->id == $subject->user_id) || ($subject->is_global) ) {
            return $self->roles()->first()->subject_view;
        } else return false;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $self
     * @return mixed
     */
    public function list(User $self) {
        return $self->roles()->first()->subject_list;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function newSubject(User $self)
    {
        return $self->roles()->first()->subject_create;
    }

    /**
     * Determine whether the user can create accounts.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function create(User $self)
    {
        return $self->roles()->first()->subject_create;
    }

    /**
     * Determine whether the user can update the account.
     *
     * @param  \App\User  $self
     * @param  \App\Subject $subject
     * @return mixed
     */
    public function update(User $self, Subject $subject)
    {
        if ( ($self->id == $subject->user_id) || (($subject->is_global) && ($self->roles()->first()->account_globals)) ) {
            return $self->roles()->first()->subject_update;
        } else return false;
    }

    /**
     * Determine whether the user can delete the account.
     *
     * @param  \App\User  $self
     * @param  \App\Subject $subject
     * @return mixed
     */
    public function delete(User $self, Subject $subject)
    {
        if ( ($self->id == $subject->user_id) || (($subject->is_global) && ($self->roles()->first()->account_globals)) ) {
            return $self->roles()->first()->subject_delete;
        } else return false;
    }

    /**
     * Can a user set it globally
     *
     * @param User $self
     * @return bool
     */
    public function setGlobal(User $self) {
        return $self->roles()->first()->subject_globals;
    }
}
