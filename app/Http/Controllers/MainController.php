<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Subject;
use App\Receipt;
use App\Account;
use App\Limit;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Templates.public.index');
        #return redirect()->route('login');
    }

    /**
     * View HOME
     *
     * @return mixed
     */
    public function home() {
        return view('Templates.home', [
            'summary' => (object)[
                'accounts' => $this->getAccountsData(),
                'subjects' => $this->getSubjectsData(),
                'limits'   => $this->getBudgetsData()
            ]
        ]);
    }

    /**
     * Returns the budgets summary
     *
     * @return array
     */
    private function getBudgetsData() {
        $result = [];

        if ( Auth::user()->cant('list', Limit::class) )
            return $result;

        $limits = Limit::where('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc');

        foreach ( $limits->get() as $limit ) {
            $percentage = ($limit->receipts()->sum('debit') * 100) / $limit->limit;
            $progress   = ceil(min(max(0, $percentage), 100));

            $result[$limit->id] = (object)[
                'name'     => $limit->name,
                'id'       => $limit->id,
                'progress' => $progress
            ];
        }

        return $result;
    }

    /**
     * Returns sum's of all accounts
     *
     * @param int $numMonths
     * @return array
     */
    private function getAccountsData($numMonths = 3) {
        $result = [];

        if ( Auth::user()->cant('list', Account::class) )
            return $result;

        $accounts = Account::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc');

        if ( empty($accounts) )
            return $result;

        setlocale(LC_TIME, "de_DE");

        foreach ( $accounts->get() as $account ) {
            $result[$account->id] = (object)[
                'name' => $account->name,
                'id'   => $account->id,
                'sumMonths' => $this->collectMonths(
                    $account,
                    $numMonths,
                    true
                )
            ];
        }

        return $result;
    }

    /**
     * Returns subjects summary of numMonths
     *
     * @param int $numMonths
     * @return array
     */
    private function getSubjectsData($numMonths = 3) {
        $result = [];

        if ( Auth::user()->cant('list', Subject::class) )
            return $result;

        $subjects = Subject::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc');

        if ( empty($subjects) )
            return $result;

        setlocale(LC_TIME, "de_DE");

        foreach ( $subjects->get() as $subject ) {
            $result[$subject->id] = (object)[
                'name' => $subject->name,
                'id'   => $subject->id,
                'sumMonths' => $this->collectMonths(
                    $subject,
                    $numMonths,
                    true
                )
            ];
        }

        return $result;
    }

    /**
     * Collects sum's of given collection and max number of Months backwards
     *
     * @param $receipts
     * @param int $numMonths
     * @return array
     */
    private function collectMonths(&$parent, $numMonths = 3, $dateBeginZero = false) {
        $result = [];

        // collect date for each month
        for ( $i = $numMonths - 1; $i >= 0; $i-- ) {
            $date = new \DateTime();
            $date->modify('-' . $i . ' month');

            $date->setTime(0, 0, 0, 0);
            $dateBegin = ( $dateBeginZero ) ? 0 : strtotime($date->format('01.m.Y H:i:s'));

            $date->setTime(23, 59, 59, 999);
            $dateEnd = strtotime($date->format('t.m.Y H:i:s'));

            $receipts = $parent->receipts()->where('date', '>=', $dateBegin)->where('date', '<=', $dateEnd);

            $result[] = (object)[
                'month'     => $date->format('m'),
                'name'      => $date->format('F'),
                'short'     => $date->format('M'),
                'sumDebit'  => $receipts->sum('debit'),
                'sumCredit' => $receipts->sum('credit')
            ];
        }

        return $result;
    }
}
