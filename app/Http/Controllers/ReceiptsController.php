<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Subject;
use App\Receipt;

class ReceiptsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * list entries
     *
     * @return mixed
     */
    public function list($startMonth = 0, $endMonth = 0) {
        if ( Auth::user()->cant('list', Receipt::class) )
            return redirect()->route('home');

        $receipts = Receipt::where('id','>',0);

        return view('Templates.receipts.list', $this->getReceiptsData($receipts));
    }

    /**
     * View an entry
     *
     * @param Receipt $receipt
     * @return mixed
     */
    public function view(Receipt $receipt) {
        if ( Auth::user()->cant('view', $receipt) )
            return redirect()->route('home');

        $accounts = Account::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        $subjects = Subject::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        $sum       = ( $receipt->credit > 0 ) ? $receipt->credit : $receipt->debit;
        $splitExpr = '/^([0-9]{1,})\.([0-9]{1,})$/';
        $sumPartA  = preg_replace($splitExpr, '\\1', $sum);
        $sumPartB  = preg_replace($splitExpr, '\\2', $sum);

        return view('Templates.receipts.view', [
            'receipt' => $receipt,
            'accounts' => $accounts,
            'subjects' => $subjects,
            'sumPartA' => $sumPartA,
            'sumPartB' => $sumPartB
        ]);
    }

    /**
     * Updates an entry
     *
     * @param Receipt $receipt
     * @param Request $request
     * @return mixed
     */
    public function update(Receipt $receipt, Request $request) {
        if ( Auth::user()->cant('update', $receipt) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100',
            'type' => 'required',
            'date' => 'required|date_format:d.m.Y',
            'account' => 'required|integer',
            'subject' => 'required|integer',
            'sumPartA' => 'required|integer',
        ]);

        $debitOrCreditField = ( $request->type == 'credit' ) ? 'credit' : 'debit';

        $receipt->name = $request->name;
        $receipt->date = strtotime($request->date . ' 00:00:00');
        $receipt->account_id = $request->account;
        $receipt->subject_id = $request->subject;
        $receipt->{$debitOrCreditField} = intval($request->sumPartA) . '.' . sprintf('%02d', intval($request->sumPartB));

        $receipt->save();

        return redirect()->route('receipts')->with('status', 'Beleg "' . $request->name . '" aktualisiert.');
    }

    /**
     * Form for new entry
     *
     * @return mixed
     */
    public function newReceipt() {
        if ( Auth::user()->cant('create', Receipt::class) )
            return redirect()->route('home');

        $accounts = Account::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        $subjects = Subject::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('Templates.receipts.newReceipt', [
            'accounts' => $accounts,
            'subjects' => $subjects
        ]);
    }

    /**
     * Creates an entry
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        if ( Auth::user()->cant('create', Receipt::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100',
            'type' => 'required',
            'date' => 'required|date_format:d.m.Y',
            'account' => 'required|integer',
            'subject' => 'required|integer',
            'sumPartA' => 'required|integer',
        ]);

        $debitOrCreditField = ( $request->type == 'credit' ) ? 'credit' : 'debit';

        Receipt::create([
            'name' => $request->name,
            'date' => strtotime($request->date . ' 00:00:00'),
            'user_id' => Auth::user()->id,
            'account_id' => $request->account,
            'subject_id' => $request->subject,
            $debitOrCreditField => intval($request->sumPartA) . '.' . sprintf('%02d', intval($request->sumPartB))
        ]);

        return redirect()->route('receipt-new')->with('status', 'Beleg "' . $request->name . '" erstellt.');
    }

    /**
     * Form for new entry
     *
     * @return mixed
     */
    public function newTransfer() {
        if ( Auth::user()->cant('create', Receipt::class) )
            return redirect()->route('home');

        $accounts = Account::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('Templates.receipts.newTransfer', [
            'accounts' => $accounts
        ]);
    }

    /**
     * Creates an entry
     *
     * @param Request $request
     * @return mixed
     */
    public function transfer(Request $request) {
        if ( Auth::user()->cant('create', Receipt::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100',
            'date' => 'required|date_format:d.m.Y',
            'accountSource' => 'required|integer',
            'accountTarget' => 'required|integer',
            'sumPartA' => 'required|integer'
        ]);

        $sum = intval($request->sumPartA) . '.' . sprintf('%02d', intval($request->sumPartB));

        // Abbuchung
        Receipt::create([
            'name' => $request->name,
            'date' => strtotime($request->date . ' 00:00:00'),
            'user_id' => Auth::user()->id,
            'account_id' => $request->accountSource,
            'subject_id' => 0,
            'debit' => $sum
        ]);

        // Einzahlung
        Receipt::create([
            'name' => $request->name,
            'date' => strtotime($request->date . ' 00:00:00'),
            'user_id' => Auth::user()->id,
            'account_id' => $request->accountTarget,
            'subject_id' => 0,
            'credit' => $sum
        ]);

        return redirect()->route('receipt-newTransfer')->with('status', 'Geldtransfer ausgeführt.');
    }

    /**
     * Deletes an entry
     *
     * @param Receipt $receipt
     * @return mixed
     */
    public function delete(Receipt $receipt) {
        if ( Auth::user()->cant('delete', $receipt) )
            return redirect()->route('home');

        $receipt->delete();

        return redirect()->route('receipts')->with('status', 'Eintrag gelöscht');
    }

    /* -------------------------------------------------------------------------------------------------------------- */

//    /**
//     * Returns receipts filtered by start-end-Month
//     *
//     * @param int $startMonth
//     * @param int $endMonth
//     * @param string $order
//     * @param int $limit
//     * @return mixed
//     */
//    public function filterReceiptsByMonth($startMonth = 1, $endMonth = 12) {
//        if ( $endMonth > $startMonth ) {
//            $startYear = date('Y');
//            $endYear   = date('Y');
//        } else {
//            $startYear = date('Y');
//            $endYear = date('Y', strtotime('+1 year'));
//        }
//
//        if ( ($endMonth < date('m', time())) && ($startMonth > $endMonth) ) {
//            $startYear = date('Y', strtotime('-1 year'));
//            $endYear   = date('Y');
//        }
//
//        $startDate = new \DateTime('now');
//        $startDate->setTime(0, 0, 0, 0);
//        $startDate->setDate($startYear, $startMonth, 1);
//        $startDate = $startDate->format('U');
//
//        $endDate = new \DateTime('now');
//        $endDate->setTime(23, 59, 59, 999);
//        $endDate->setDate($endYear, $endMonth, $endDate->format('t'));
//        $endDate = $endDate->format('U');
//
//        return Receipt::where('date', '>=', $startDate)
//            ->where('date', '<', $endDate);
//    }
}
