<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersController extends Controller
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
     * lists all users
     *
     * @return mixed
     */
    public function list() {
        if ( Auth::user()->cant('list', User::class) )
            return redirect()->route('home');

        $users = User::orderBy('name', 'asc')->get();

        return view('Templates.users.list', [
            'users' => $users
        ]);
    }

    /**
     * Shows a user
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user) {
        if ( Auth::user()->cant('view', $user) )
            return redirect()->route('home');

        $roles = Role::orderBy('name', 'asc')->get();

        return view('Templates.users.view', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Updates a user
     *
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function update(User $user, Request $request) {
        if ( Auth::user()->cant('update', $user) )
            return redirect()->route('home');

        if ( !empty($request->password) ) {
            $request->validate([
                'password' => 'required|min:4|max:100|confirmed'
            ]);

            $user->password = Hash::make($request->password);
        }

        // The user cannot disable itself
        if ( $user->id !== Auth::user()->id ) {
            $user->disabled = (bool)$request->disabled;
            $user->role_id = intval($request->role);
        }

        $user->save();

        return redirect()->route('user-view', [$user])->with('status', 'Aktualisierung erfolgreich');;
    }

    /**
     * Form for a new user
     *
     * @return mixed
     */
    public function newUser() {
        if ( Auth::user()->cant('create', User::class) )
            return redirect()->route('home');

        $roles = Role::orderBy('name', 'asc')->get();

        return view('Templates.users.newUser', [
            'roles' => $roles
        ]);
    }

    /**
     * Creates a user
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        if ( Auth::user()->cant('create', User::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:1,100',
            'email' => 'bail|required|email|confirmed',
            'password' => 'required|min:6|max:100|confirmed',
            'role' => 'required|integer'
        ]);

        $role = Role::find($request->role);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => str_random(10),
            'role_id' => ( $role ) ? $role->id : '3'
        ]);

        return redirect()->route('users')->with('status', 'Nutzer "' . $request->name . '"" erstellt');
    }

    /**
     * Deletes a user
     * @todo alle anderen datensätze des nutzers löschen (auch die subjects, etc. sofern nicht GLOBALS)
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user) {
        if ( Auth::user()->cant('delete', $user) )
            return redirect()->route('home');

        $name = $user->name;

        $user->delete();

        return redirect()->route('users')->with('status', 'Nutzer "' . $name . '"" entfernt');
    }
}
