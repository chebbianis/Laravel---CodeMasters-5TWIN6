<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participation;
use App\Models\User;

class EventController extends Controller
{
    public function index() {
        $events = Event::withCount('participations')->get();
        return view('events.index', compact('events'));
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {
    $request->validate([
        'title' => 'required',
        'type' => 'required',
        'date' => 'required|date',
        'location' => 'required',
        'max_participants' => 'required|integer',
        'description' => 'nullable',
    ]);
    $data = $request->all();
    $data['organizer_id'] = 1; // Valeur par défaut tant que la gestion des users n'est pas faite
    Event::create($data);
    return redirect()->route('events.workshops')->with('success', 'Événement créé avec succès');
}

   

    public function update(Request $request, Event $event) {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'max_participants' => 'required|integer',
            'description' => 'nullable',
        ]);
        $event->update($request->all());
        return redirect()->route('events.workshops')->with('success', 'Événement mis à jour');
    }

    public function destroy(Event $event) {
        $event->delete();
        return redirect()->route('events.workshops')->with('success', 'Événement supprimé');
    }

    public function workshops() {
        $events = Event::orderBy('date', 'asc')->get();
        return view('events.workshops', compact('events'));
    }

    public function participations(Request $request) {
        $events = Event::with(['participations.user'])->get();
        $participations = Participation::with(['event', 'user'])->latest()->get();
        return view('events.participations', compact('events', 'participations'));
    }
}