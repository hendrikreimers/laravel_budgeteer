<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;

class RolesController extends Controller
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
     * lists all roles
     *
     * @return mixed
     */
    public function list() {
        if ( Auth::user()->cant('list', Role::class) )
            return redirect()->route('home');

        $roles = Role::orderBy('name', 'asc')->get();

        return view('Templates.roles.list', [
            'roles' => $roles
        ]);
    }

    /**
     * Shows a role
     *
     * @param Role $role
     * @return mixed
     */
    public function view(Role $role) {
        if ( Auth::user()->cant('view', $role) )
            return redirect()->route('home');

        return view('Templates.roles.view', [
            'role' => $role,
            'roleFillables' => $role->attributesToArray()
        ]);
    }

    /**
     * Updates a role
     *
     * @param Role $role
     * @param Request $request
     * @return mixed
     */
    public function update(Role $role, Request $request) {
        if ( Auth::user()->cant('update', $role) )
            return redirect()->route('home');

        if ( !empty($request->rules) ) {
            foreach ( $role->attributesToArray() as $rule => $oldValue ) {
                if ( preg_match('/^(.*)_(view|list|create|update|delete|globals)$/i', $rule) ) {
                    if ( !empty($request->rules[$rule]) ) {
                        $role->{$rule} = boolval($request->rules[$rule]);
                    } else $role->{$rule} = false;
                }
            }
        }

        $role->save();

        return redirect()->route('role-view', [$role])->with('status', 'Aktualisierung erfolgreich');;
    }

    /**
     * Form for a new user
     *
     * @return mixed
     */
    public function newRole() {
        if ( Auth::user()->cant('create', Role::class) )
            return redirect()->route('home');

        $role = new Role();

        return view('Templates.roles.newRole', [
            'fillable' => $role->getFillable()
        ]);
    }

    /**
     * Creates a role
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        if ( Auth::user()->cant('create', Role::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100'
        ]);

        $role = new Role();

        $role->name = $request->name;

        foreach ( $role->getFillable() as $rule ) {
            if ( preg_match('/^(.*)_(view|list|create|update|delete|globals)$/i', $rule) ) {
                if ( !empty($request->rules[$rule]) ) {
                    $role->{$rule} = true;
                } else $role->{$rule} = false;
            }
        }

        $role->save();

        return redirect()->route('roles')->with('status', 'Gruppe "' . $request->name . '"" erstellt');
    }

    /**
     * Deletes a user
     *
     * @param Role $role
     * @return mixed
     */
    public function delete(Role $role) {
        if ( Auth::user()->cant('delete', $role) )
            return redirect()->route('home');

        $name = $role->name;

        $role->delete();

        return redirect()->route('roles')->with('status', 'Gruppe "' . $name . '"" entfernt');
    }
}
