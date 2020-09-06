<?php

namespace App\Policies;

use App\User;
use App\Receipt;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the receipt.
     *
     * @param  \App\User  $self
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function view(User $self, Receipt $receipt)
    {
        return ( ($self->roles()->first()->receipt_view) && ($self->id == $receipt->user_id) ) ? true : false;
    }

    /**
     * Determine whether the user can list the users.
     *
     * @param User $self
     * @return mixed
     */
    public function list(User $self) {
        return $self->roles()->first()->receipt_list;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function newReceipt(User $self)
    {
        return $self->roles()->first()->receipt_create;
    }

    /**
     * Determine whether the user can create receipts.
     *
     * @param  \App\User  $self
     * @return mixed
     */
    public function create(User $self)
    {
        return $self->roles()->first()->receipt_create;
    }

    /**
     * Determine whether the user can update the receipt.
     *
     * @param  \App\User  $self
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function update(User $self, Receipt $receipt)
    {
        return ( ($self->roles()->first()->receipt_update) && ($self->id == $receipt->user_id) ) ? true : false;
    }

    /**
     * Determine whether the user can delete the receipt.
     *
     * @param  \App\User  $self
     * @param  \App\Receipt  $receipt
     * @return mixed
     */
    public function delete(User $self, Receipt $receipt)
    {
        return ( ($self->roles()->first()->receipt_delete) && ($self->id == $receipt->user_id) ) ? true : false;
    }
}
