<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Subject;

class SubjectsController extends Controller
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
        if ( Auth::user()->cant('list', Subject::class) )
            return redirect()->route('home');

        $subjects = Subject::where('is_global','=',true)
            ->orWhere('user_id','=',Auth::user()->id)
            ->orderBy('name', 'asc')->paginate(10);

        return view('Templates.subjects.list', [
            'subjects' => $subjects
        ]);
    }

    /**
     * View an entry
     *
     * @param Subject $subject
     * @return mixed
     */
    public function view(Subject $subject) {
        if ( Auth::user()->cant('view', $subject) )
            return redirect()->route('home');

        return view('Templates.subjects.view', array_merge(
            ['subject' => $subject],
            $this->getReceiptsData($subject->receipts())
        ));
    }

    /**
     * Updates an entry
     *
     * @param Subject $subject
     * @param Request $request
     * @return mixed
     */
    public function update(Subject $subject, Request $request) {
        if ( Auth::user()->cant('update', $subject) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100'
        ]);

        $subject->name = $request->name;
        $subject->save();

        return redirect()->route('subjects')->with('status', 'Datensatz aktualisiert');
    }

    /**
     * Form for new entry
     *
     * @return mixed
     */
    public function newSubject() {
        if ( Auth::user()->cant('create', Subject::class) )
            return redirect()->route('home');

        return view('Templates.subjects.newSubject');
    }

    /**
     * Creates an entry
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        if ( Auth::user()->cant('create', Subject::class) )
            return redirect()->route('home');

        $request->validate([
            'name' => 'required|between:3,100'
        ]);

        Subject::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'is_global' => ( isset($request->global) ) ? true : false
        ]);

        return redirect()->route('subjects')->with('status', 'Konto "' . $request->name . '" erstellt.');
    }

    /**
     * Deletes an entry
     *
     * @param Subject $subject
     * @return mixed
     */
    public function delete(Subject $subject) {
        if ( Auth::user()->cant('delete', $subject) )
            return redirect()->route('home');

        if ( (Auth::user()->id == $subject->user_id) || ($subject->is_global) ) {
            $name     = $subject->name;
            $receipts = \App\Receipt::where('subject_id', '=', $subject->id)->get();

            try {
                $receipts->delete();
            } catch(\Exception $e) {}

            $subject->delete();

            return redirect()->route('subjects')->with('status', 'Konto "' . $name . '" und alle Belege gelöscht!');
        } else return redirect()->route('subjects');
    }
}
