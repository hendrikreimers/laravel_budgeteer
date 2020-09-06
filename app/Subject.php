<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    protected $fillable = [
        'user_id', 'name', 'is_global'
    ];

    public function receipts() {
        return $this->hasMany('App\Receipt')
            ->where('user_id', '=', Auth::user()->id);
    }
}
