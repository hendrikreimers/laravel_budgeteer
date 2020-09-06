<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;

class AccountsController extends Controller
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
        if ( Auth::user()->cant('list', Account::class) )
            return redirect()->route('home');

        $accounts = Account::where('is_global','=',true)
            ->orWhere('user_id','=',Auth::user()->id)
            ->orderBy('name', 'asc')->paginate(10);

        return view('Templates.accounts.list', [
            'accounts' => $accounts
        ]);
    }

    /**
     * View an entry
     *
     * @param Account $account
     * @return mixed
     */
    public function view(Account $account) {
        if ( Auth::user()->cant('view', $account) )
            return redirect()->route('home');

        return view('Templates.accounts.view', array_merge(
            ['account' => $account],
            $this->getReceiptsData($account->receipts())
        ));
    }

    /**
     * Updates an entry
     *
     * @param Account $account
     * @param Request $request
     * @return mixed
     */
    public function update(Account $account, Request $request) {
        if ( Auth::user()->cant('update', $account) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100'
        ]);

        $account->name = $request->name;
        $account->save();

        return redirect()->route('accounts')->with('status', 'Datensatz aktualisiert');
    }

    /**
     * Form for new entry
     *
     * @return mixed
     */
    public function newAccount() {
        if ( Auth::user()->cant('create', Account::class) )
            return redirect()->route('home');

        return view('Templates.accounts.newAccount');
    }

    /**
     * Creates an entry
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        if ( Auth::user()->cant('create', Account::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100'
        ]);

        Account::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'is_global' => ( isset($request->global) ) ? true : false
        ]);

        return redirect()->route('accounts')->with('status', 'Konto "' . $request->name . '" erstellt.');
    }

    /**
     * Deletes an entry
     *
     * @param Account $account
     * @return mixed
     */
    public function delete(Account $account) {
        if ( Auth::user()->cant('delete', $account) )
            return redirect()->route('home');

        if ( (Auth::user()->id == $account->user_id) || ($account->is_global) ) {
            $name     = $account->name;
            $receipts = \App\Receipt::where('account_id', '=', $account->id)->get();

            try {
                $receipts->delete();
            } catch(\Exception $e) {}

            $account->delete();

            return redirect()->route('accounts')->with('status', 'Konto "' . $name . '" und alle Belege gelöscht!');
        } else return redirect()->route('accounts');
    }
}
