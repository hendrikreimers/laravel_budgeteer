<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returns the filtered receipts
     *
     * @param $receipts
     * @return array
     */
    public function getReceiptsData($receipts) {
        request()->validate(['sort' => 'alpha']);
        $sortBy = ( request()->sort ) ? request()->sort : 'date';

        if ( request()->startDate && request()->endDate ) {
            request()->validate([
                'startDate' => 'required|date_format:d.m.Y',
                'endDate' => 'required|date_format:d.m.Y'
            ]);

            $start = strtotime(request()->startDate. ' 00:00:00');
            $end   = strtotime(request()->endDate . ' 23:59:59');

            $receipts = $receipts->where('date', '>=', $start)
                ->where('date', '<=', $end)
                ->where('user_id','=', Auth::user()->id)
                ->orderBy($sortBy, 'desc');

            $startDate = request()->startDate;
            $endDate = request()->endDate;
        } else {
            $startDate = '';
            $endDate   = '';

            $receipts = $receipts->where('user_id','=', Auth::user()->id)
                ->orderBy($sortBy, 'desc');
        }

        return [
            'receipts' => $receipts,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
}
