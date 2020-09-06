<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Receipt;

class Limit extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'subject_id',
        'name', 'limit'
    ];

    public function receipts() {
        if ( request()->startDate && request()->endDate ) {
            request()->validate([
                'startDate' => 'required|date_format:d.m.Y',
                'endDate' => 'required|date_format:d.m.Y'
            ]);

            $startDate = request()->startDate;
            $endDate = request()->endDate;
        } else {
            $startDate = date('1.m.Y');
            $endDate   = date('t.m.Y');
        }

        $start = strtotime($startDate . ' 00:00:00');
        $end   = strtotime($endDate . ' 23:59:59');

        if ( $this->subject_id > 0 ) {
            $receipts = Receipt::where('user_id', '=', Auth::user()->id)
                ->where('account_id', '=', $this->account_id)
                ->where('subject_id', '=', $this->subject_id)
                ->where('date', '>=', $start)
                ->where('date', '<=', $end);
        } else {
            $receipts = Receipt::where('user_id', '=', Auth::user()->id)
                ->where('account_id', '=', $this->account_id)
                ->where('date', '>=', $start)
                ->where('date', '<=', $end);
        }

        return $receipts;
    }
}
