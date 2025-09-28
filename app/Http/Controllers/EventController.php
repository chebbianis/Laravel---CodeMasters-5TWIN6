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

    public function workshops(Request $request)
{
    $query = Event::query();

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    $events = $query->orderBy('date', 'asc')->get();

    return view('events.workshops', compact('events'));
}


    public function participations(Request $request)
{
    $events = Event::with('participations')->get();

    $stats = [
        'total' => Participation::count(),
        'confirmed' => Participation::where('status', 'confirmed')->count(),
        'pending' => Participation::where('status', 'pending')->count(),
        'cancelled' => Participation::where('status', 'cancelled')->count(),
    ];

    return view('events.participations', compact('events', 'stats'));
}
public function export($format)
    {
        // Ici tu peux gérer l'export Excel, CSV ou PDF
        // Exemple simple :
        return "Export demandé au format : " . $format;
    }
}