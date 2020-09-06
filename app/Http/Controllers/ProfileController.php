<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class ProfileController extends Controller
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
     * Shows the user profile
     *
     * @return mixed
     */
    public function view() {
        return view('Templates.profile.view', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Updates the current user
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request) {
        $user = User::find(Auth::user()->id);

        if ( !empty($request->password) ) {
            $request->validate([
                'password' => 'required|min:6|max:100|confirmed'
            ]);

            $user->password = Hash::make($request->password);

            $user->save();

            return redirect()->route('profile')->with('status', 'Profil aktualisiert!');
        } else return redirect()->route('profile');
    }
}
