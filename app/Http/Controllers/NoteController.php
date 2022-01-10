<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NoteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
//        $this->middleware('can:admin');
    }

    public function index()
    {
        return view('Admin.notes.index')->with([
            'notes' => Note:: latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('Admin.notes.edit', [
            'action' => route('notes.store'),
            'method' => null,
            'data'   => null
        ]);
    }

    public function store(NoteRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $note = Note::create($validated);

        return redirect()->route('notes.index')->with('success', "Qeyd {$note->getAttribute('note')} uğurla yaradıldı!");
    }

    public function show(Note $note)
    {
        return view('Admin.notes.edit', [
            'action' => null,
            'method' => null,
            'data'   => $note
        ]);
    }

    public function edit(Note $note)
    {
        return view('Admin.notes.edit', [
            'action' => route('notes.update', $note),
            'method' => "PUT",
            'data'   => $note
        ]);
    }

    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        $validated = $request->validated();

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', "Qeyd {$note->getAttribute('note')} uğurla dəyişdirildi!");
    }

    public function destroy(Note $note): JsonResponse
    {
        if($note->delete()){
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
