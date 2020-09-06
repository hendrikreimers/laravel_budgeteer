<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_view', 'user_list', 'user_create', 'user_update', 'user_delete',
        'role_view', 'role_list', 'role_create', 'role_update', 'role_delete',
        'subject_view', 'subject_list', 'subject_create', 'subject_update', 'subject_delete', 'subject_globals',
        'account_view', 'account_list', 'account_create', 'account_update', 'account_delete', 'account_globals',
        'receipt_view', 'receipt_list', 'receipt_create', 'receipt_update', 'receipt_delete',
        'limit_view', 'limit_list', 'limit_create', 'limit_update', 'limit_delete'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get users inside this group (role)
     *
     * @return mixed
     */
    public function users() {
        return $this->hasMany('App\User');
    }

    /**
     * Checks if attribute exists
     *
     * @param string $attr
     * @return bool
     */
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    /**
     * Returns the fillable attributes
     *
     * @return array
     */
    public function getFillable() {
        return $this->fillable;
    }
}
