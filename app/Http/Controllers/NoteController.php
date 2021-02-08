<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function postNote(Request $request) 
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:5'
        ]);

        $user = Auth::user();

        $note = new Note([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $user->notes()->save($note);

        return redirect()->route('home')->with('info', 'Note successfully created.');
    }

    public function getAllNotes()
    {
        return view('home', ['notes' => Note::all()]);
    }

    public function getUserNotes() 
    {
        $user = Auth::user();
        $notes = Note::where('deleted', '=', '0')
            ->where('user_id', '=', $user->id)
            ->get();
        return view('home', ['notes' => $notes]);
    }

    public function getNote($id)
    {
        return view('edit', ['note' => Note::find($id)]);
    }

    public function editNote(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        $note = Note::find($request->input('id'));
        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return redirect()->route('home')->with('info', 'Note successfully edited.');
    }

}
