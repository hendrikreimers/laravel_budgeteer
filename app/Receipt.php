<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Receipt extends Model
{
    protected $fillable = [
        'user_id', 'subject_id', 'account_id',
        'date', 'name',
        'debit', 'credit'
    ];

    public function subject() {
        return $this->belongsTo('App\Subject', 'subject_id')->first();
    }
}
