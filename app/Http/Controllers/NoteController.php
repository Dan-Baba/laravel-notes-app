<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Post new note associated with authenticated user, requires the request to have 'title' & 'content'.
     * Author: Daniel Dragon
     */
    public function postNote(Request $request) 
    {
        $user = Auth::user();
        
        // Validate the request has title & content.
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:5'
        ]);

        // Create the note
        $note = new Note([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        // Save it to the authenticated user.
        $user->notes()->save($note);

        return redirect()->route('home')->with('info', 'Note successfully created.');
    }

    /**
     * Get current authenticated users notes that aren't soft-deleted.
     * Author: Daniel Dragon
     */
    public function getCurrentUsersNotes() 
    {
        $user = Auth::user();
        // Get notes from user where they're not soft-deleted.
        $notes = $user->notes()->where('deleted', '=', '0')->get();
        return view('home', ['notes' => $notes]);
    }

    /**
     * Get note by ID if user has access to it.
     * Author: Daniel Dragon
     */
    public function getNote($id)
    {
        $user = Auth::user();
        // Check authenticated users notes for this Id.
        $note = $user->notes()->find($id);
        // If not found, could be user doesn't have access or they landed on an ID that doesn't exist
        if ($note == null) {
            return view('errors.404');
        }
        return view('edit', ['note' => $note]);
    }

    /**
     * Update note with contents of request.
     * Author: Daniel Dragon
     */
    public function updateNote(Request $request)
    {
        $user = Auth::user();

        //Validate this note
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        // Find note in authenticated users notes.
        $note = $user->notes()->find($request->input('id')); //Note::find($request->input('id'));
        if ($note == null) {
            return view('errors.404');
        }
        
        // Update content and save.
        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return redirect()->route('home')->with('info', 'Note successfully edited.');
    }

}
