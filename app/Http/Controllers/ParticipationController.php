<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participation;
use App\Models\Event;
use Illuminate\Support\Facades\Http; // ⭐ AJOUT

class ParticipationController extends Controller
{
    public function index(Request $request) {
        $events = Event::with(['participations' => function($query) use ($request) {
            if ($request->event) {
                $query->where('event_id', $request->event);
            }
            if ($request->status) {
                $query->where('status', $request->status);
            }
            if ($request->date) {
                $query->whereDate('registration_date', $request->date);
            }
        }])->get();

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

    public function store(Request $request) {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'participant_name' => 'required',
            'participant_email' => 'required|email',
            'participant_feedback' => 'nullable', // ⭐ NOUVEAU : Feedback optionnel
        ]);

        // Vérifier si l'événement n'est pas complet
    $events = Event::withCount(['participations' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('date', 'asc')
            ->get();

        return view('events.events-front', compact('events'));
    }
    public function destroy(Participation $participation) {
        $participation->delete();
        return back()->with('success', 'Participation supprimée !');
    }

    public function confirm(Participation $participation) {
        $participation->update(['status' => 'confirmed']);
        return back()->with('success', 'La participation a été confirmée ✅');
    }

    public function cancel(Participation $participation) {
        $participation->update(['status' => 'cancelled']);
        return back()->with('success', 'La participation a été annulée ❌');
    }

    // ⭐⭐ NOUVELLE MÉTHODE : Ajouter un feedback à une participation existante
    public function addFeedback(Request $request, Participation $participation) {
        $request->validate([
            'feedback' => 'required|string|min:10',
        ]);

        $notes = json_decode($participation->notes, true) ?? [];
        $notes['feedback'] = $request->feedback;
        
        $participation->update([
            'notes' => json_encode($notes)
        ]);

        return back()->with('success', 'Feedback ajouté avec succès !');
    }

    // ⭐⭐ NOUVELLE MÉTHODE : Analyser le feedback d'un participant spécifique
    public function analyzeParticipantFeedback(Participation $participation) {
        $notes = json_decode($participation->notes, true) ?? [];
        $feedback = $notes['feedback'] ?? null;

        if (!$feedback) {
            return response()->json([
                'success' => false,
                'error' => 'Aucun feedback à analyser pour ce participant'
            ]);
        }

        $token = config('services.huggingface.api_key');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment-latest', [
                'inputs' => $feedback,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $sentiment = $result[0][0]['label'] ?? 'neutral';
                $score = $result[0][0]['score'] ?? 0;

                return response()->json([
                    'success' => true,
                    'participant' => $notes['name'] ?? 'Inconnu',
                    'feedback' => $feedback,
                    'sentiment' => $sentiment,
                    'score' => $score,
                    'event' => $participation->event->title
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Erreur API'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur de traitement: ' . $e->getMessage()
            ], 500);
        }
    }
    
}