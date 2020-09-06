<?php

namespace App\Policies;

use App\User;
use App\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the account.
     *
     * @param  \App\User  $self
     * @param  \App\Account  $account
     * @return bool
     */
    public function view(User $self, Account $account)
    {
        if ( ($self->id == $account->user_id) || ($account->is_global) ) {
            return $self->roles()->first()->account_view;
        } else return false;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $self
     * @return bool
     */
    public function list(User $self) {
        return $self->roles()->first()->account_list;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $self
     * @return bool
     */
    public function newAccount(User $self)
    {
        return $self->roles()->first()->account_create;
    }

    /**
     * Determine whether the user can create accounts.
     *
     * @param  \App\User  $self
     * @return bool
     */
    public function create(User $self)
    {
        return $self->roles()->first()->account_create;
    }

    /**
     * Determine whether the user can update the account.
     *
     * @param  \App\User  $self
     * @param  \App\Account  $account
     * @return bool
     */
    public function update(User $self, Account $account)
    {
        if ( ($self->id == $account->user_id) || (($account->is_global) && ($self->roles()->first()->account_globals)) ) {
            return $self->roles()->first()->account_update;
        } else return false;
    }

    /**
     * Determine whether the user can delete the account.
     *
     * @param  \App\User  $self
     * @param  \App\Account  $account
     * @return bool
     */
    public function delete(User $self, Account $account)
    {
        if ( ($self->id == $account->user_id) || (($account->is_global) && ($self->roles()->first()->account_globals)) ) {
            return $self->roles()->first()->account_delete;
        } else return false;
    }

    /**
     * Can a user set it globally
     *
     * @param User $self
     * @return bool
     */
    public function setGlobal(User $self) {
        return $self->roles()->first()->account_globals;
    }
}
