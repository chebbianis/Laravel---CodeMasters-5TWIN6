<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participation;
use App\Models\Event;

class ParticipationController extends Controller
{

    public function index(Request $request)
{
    // Récupère tous les événements
    $events = Event::with(['participations' => function($query) use ($request) {
        // Filtre par événement si sélectionné
        if ($request->event) {
            $query->where('event_id', $request->event);
        }

        // Filtre par statut si sélectionné
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filtre par date si sélectionnée
        if ($request->date) {
            $query->whereDate('registration_date', $request->date);
        }
    }])->get();

    // Stats dynamiques pour les filtres
    $allParticipations = Participation::query();

    if ($request->event) $allParticipations->where('event_id', $request->event);
    if ($request->status) $allParticipations->where('status', $request->status);
    if ($request->date) $allParticipations->whereDate('registration_date', $request->date);

    $stats = [
        'total' => $allParticipations->count(),
        'confirmed' => (clone $allParticipations)->where('status','confirmed')->count(),
        'pending' => (clone $allParticipations)->where('status','pending')->count(),
        'cancelled' => (clone $allParticipations)->where('status','cancelled')->count(),
    ];

    return view('events.participations', compact('events', 'stats'));
}


    public function store(Request $request)
{
    $request->validate([
        'event_id' => 'required|exists:events,id',
        'participant_name' => 'required',
        'participant_email' => 'required|email',
    ]);

    Participation::create([
        'event_id' => $request->event_id,
        'user_id' => null,
        'status' => 'pending', // <-- ici
        'notes' => json_encode([
            'name' => $request->participant_name,
            'email' => $request->participant_email,
        ]),
        'registration_date' => now(),
    ]);

    return back()->with('success', 'Inscription enregistrée !');
}

    // Supprime une participation
    public function destroy(Participation $participation)
    {
        $participation->delete();
        return back()->with('success', 'Participation supprimée !');
    }

public function confirm(Participation $participation)
{
    $participation->update(['status' => 'confirmed']);
    return back()->with('success', 'La participation a été confirmée ✅');
}

public function cancel(Participation $participation)
{
    $participation->update(['status' => 'cancelled']);
    return back()->with('success', 'La participation a été annulée ❌');
}



}
