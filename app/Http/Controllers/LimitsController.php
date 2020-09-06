<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Limit;
use App\Account;
use App\Subject;
use App\Receipt;

class LimitsController extends Controller
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
    public function list() {
        if ( Auth::user()->cant('list', Limit::class) )
            return redirect()->route('home');

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

        $limits = Limit::where('user_id','=', Auth::user()->id)
            ->orderBy('name', 'asc');

        return view('Templates.limits.list', [
            'limits'    => $limits,
            'startDate' => $startDate,
            'endDate'   => $endDate
        ]);
    }

    /**
     * View an entry
     *
     * @param Limit $limit
     * @return mixed
     */
    public function view(Limit $limit) {
        if ( Auth::user()->cant('view', $limit) )
            return redirect()->route('home');

        $accounts = Account::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        $subjects = Subject::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        $splitExpr = '/^([0-9]{1,})\.([0-9]{1,})$/';
        $sumPartA  = preg_replace($splitExpr, '\\1', $limit->limit);
        $sumPartB  = preg_replace($splitExpr, '\\2', $limit->limit);

        return view('Templates.limits.view', [
            'limit' => $limit,
            'accounts' => $accounts,
            'subjects' => $subjects,
            'sumPartA' => $sumPartA,
            'sumPartB' => $sumPartB
        ]);
    }

    /**
     * Updates an entry
     *
     * @param Limit $limit
     * @param Request $request
     * @return mixed
     */
    public function update(Limit $limit, Request $request) {
        if ( Auth::user()->cant('update', $limit) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100',
            'account' => 'required|integer',
            'subject' => 'required|integer',
            'sumPartA' => 'required|integer',
            'sumPartB' => 'required|integer'
        ]);

        $limit->name       = $request->name;
        $limit->account_id = $request->account;
        $limit->subject_id = $request->subject;
        $limit->limit      = $request->sumPartA . '.' . $request->sumPartB;

        $limit->save();

        return redirect()->route('limits')->with('status', 'Datensatz aktualisiert');
    }

    /**
     * Form for new entry
     *
     * @return mixed
     */
    public function newLimit() {
        if ( Auth::user()->cant('create', Limit::class) )
            return redirect()->route('home');

        $accounts = Account::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        $subjects = Subject::where('is_global', '=', true)
            ->orWhere('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('Templates.limits.newLimit', [
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
        if ( Auth::user()->cant('create', Limit::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100',
            'account' => 'required|integer',
            'subject' => 'integer',
            'sumPartA' => 'required|integer',
            'sumPartB' => 'required|integer'
        ]);

        Limit::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'account_id' => $request->account,
            'subject_id' => intval($request->subject),
            'limit' => $request->sumPartA . '.' . $request->sumPartB
        ]);

        return redirect()->route('limits')->with('status', 'Konto "' . $request->name . '" erstellt.');
    }

    /**
     * Deletes an entry
     *
     * @param Limit $limit
     * @return mixed
     */
    public function delete(Limit $limit) {
        if ( Auth::user()->cant('delete', $limit) )
            return redirect()->route('home');

        if ( Auth::user()->id == $limit->user_id ) {
            $name = $limit->name;

            $limit->delete();

            return redirect()->route('limits')->with('status', 'Budget "' . $name . '" gelöscht!');
        } else return redirect()->route('limits');
    }
}
