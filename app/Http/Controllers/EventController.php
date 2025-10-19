<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon; // ⭐ AJOUT
use Barryvdh\DomPDF\Facade\Pdf; // ⭐ AJOUT
use Maatwebsite\Excel\Facades\Excel; // ⭐ AJOUT
use App\Exports\EventsExport; // ⭐ AJOUT
use App\Exports\ParticipationsExport; // ⭐ AJOUT

class EventController extends Controller
{
    public function index() {
        $events = Event::withCount('participations')->get();
        
        $sentimentStats = $this->getSentimentStats();
        
        return view('events.index', compact('events', 'sentimentStats'));
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
        $data['organizer_id'] = 1;
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

    public function workshops(Request $request) {
        $query = Event::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Charger avec le compte des participations CONFIRMÉES
        $events = $query->withCount(['participations' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->withCount(['participations as feedbacks_count' => function($query) {
                $query->where('status', 'confirmed')
                      ->where('notes', 'LIKE', '%"is_feedback":true%');
            }])
            ->orderBy('date', 'asc')
            ->get();

        return view('events.workshops', compact('events'));
    }

    public function participations(Request $request) {
        // Charger avec le compte des participations
        $events = Event::withCount(['participations' => function($query) use ($request) {
                if ($request->event) {
                    $query->where('event_id', $request->event);
                }
                if ($request->status) {
                    $query->where('status', $request->status);
                }
            }])
            ->get();

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

    // Méthode pour la page front des événements
    public function eventsFront() {
        // Charger avec le compte des participations CONFIRMÉES
        $events = Event::withCount(['participations' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('date', 'asc')
            ->get();

        return view('events.events-front', compact('events'));
    }

    public function export($format) {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        
        switch ($format) {
            case 'pdf':
                $events = Event::withCount(['participations' => function($query) {
                    $query->where('status', 'confirmed');
                }])->get();
                
                $pdf = Pdf::loadView('exports.events-pdf', compact('events'));
                return $pdf->download("evenements_{$timestamp}.pdf");
                
            case 'csv':
                return Excel::download(new EventsExport, "evenements_{$timestamp}.csv", \Maatwebsite\Excel\Excel::CSV);
                
            case 'excel':
                return Excel::download(new EventsExport, "evenements_{$timestamp}.xlsx");
                
            default:
                return back()->with('error', 'Format non supporté');
        }
    }

    public function exportParticipations($format) {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        
        switch ($format) {
            case 'pdf':
                $participations = Participation::with('event')->get();
                $stats = [
                    'total' => $participations->count(),
                    'confirmed' => $participations->where('status', 'confirmed')->count(),
                    'pending' => $participations->where('status', 'pending')->count(),
                    'cancelled' => $participations->where('status', 'cancelled')->count(),
                ];
                
                $pdf = Pdf::loadView('exports.participations-pdf', compact('participations', 'stats'));
                return $pdf->download("participations_{$timestamp}.pdf");
                
            case 'csv':
                return Excel::download(new ParticipationsExport, "participations_{$timestamp}.csv", \Maatwebsite\Excel\Excel::CSV);
                
            case 'excel':
                return Excel::download(new ParticipationsExport, "participations_{$timestamp}.xlsx");
                
            default:
                return back()->with('error', 'Format non supporté');
        }
    }

    // Méthodes pour l'analyse de sentiment
    public function analyzeEventFeedback(Request $request, $eventId) {
        $event = Event::with(['participations' => function($query) {
            $query->where('status', 'confirmed')
                  ->where('notes', 'LIKE', '%"is_feedback":true%');
        }])->find($eventId);
        
        if (!$event) {
            return response()->json(['error' => 'Événement non trouvé'], 404);
        }

        // Récupérer tous les commentaires des participants
        $allFeedback = $event->participations
            ->pluck('notes')
            ->filter()
            ->map(function($note) {
                $decoded = json_decode($note, true);
                return $decoded['feedback'] ?? $decoded['comment'] ?? null;
            })
            ->filter()
            ->implode(' ');

        if (empty($allFeedback)) {
            return response()->json([
                'success' => false,
                'error' => 'Aucun feedback à analyser pour cet événement'
            ]);
        }

        // Appel à l'API Hugging Face
        $token = config('services.huggingface.api_key');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment-latest', [
                'inputs' => $allFeedback,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $sentiment = $result[0][0]['label'] ?? 'neutral';
                $score = $result[0][0]['score'] ?? 0;
                
                // Sauvegarder l'analyse dans l'événement
                $event->sentiment_analysis = $sentiment;
                $event->sentiment_score = $score;
                $event->last_analyzed_at = now();
                $event->save();

                return response()->json([
                    'success' => true,
                    'event' => $event->title,
                    'sentiment' => $sentiment,
                    'score' => $score,
                    'feedback_count' => $event->participations->count(),
                    'text_analyzed' => $allFeedback
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Erreur API HuggingFace: ' . $response->status()
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur de traitement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSentimentStats() {
        $eventsWithSentiment = Event::whereNotNull('sentiment_analysis')->get();
        
        $stats = [
            'total_analyzed' => $eventsWithSentiment->count(),
            'positive' => $eventsWithSentiment->where('sentiment_analysis', 'positive')->count(),
            'neutral' => $eventsWithSentiment->where('sentiment_analysis', 'neutral')->count(),
            'negative' => $eventsWithSentiment->where('sentiment_analysis', 'negative')->count(),
            'average_score' => $eventsWithSentiment->avg('sentiment_score') ?? 0,
        ];

        return $stats;
    }

    public function analyzeAllEvents() {
        $recentEvents = Event::where('date', '>=', now()->subMonths(3))
                            ->whereNull('sentiment_analysis')
                            ->get();

        $results = [];
        
        foreach ($recentEvents as $event) {
            $analysis = $this->analyzeEventFeedback(new Request(), $event->id);
            $results[] = json_decode($analysis->getContent(), true);
        }

        return response()->json([
            'success' => true,
            'message' => 'Analyse de ' . count($results) . ' événements terminée',
            'results' => $results
        ]);
    }

    public function updateEventStats($eventId)
    {
        try {
            $event = Event::find($eventId);
            if (!$event) {
                return false;
            }

            // Récupérer les feedbacks avec la nouvelle logique
            $feedbacks = Participation::where('event_id', $eventId)
                ->where('status', 'confirmed')
                ->where('notes', 'LIKE', '%"is_feedback":true%')
                ->get();

            $ratings = [];
            $sentiments = [];

            foreach ($feedbacks as $feedback) {
                $notes = json_decode($feedback->notes, true);
                
                if (isset($notes['rating'])) {
                    $ratings[] = (int)$notes['rating'];
                }
                
                if (isset($notes['sentiment_analysis'])) {
                    $sentiments[] = $notes['sentiment_analysis'];
                }
            }

            // Calculer les stats
            $averageRating = count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 2) : 0;
            $ratingCount = count($ratings);
            $positive = count(array_filter($sentiments, fn($s) => $s === 'positive'));
            $negative = count(array_filter($sentiments, fn($s) => $s === 'negative'));
            $neutral = count(array_filter($sentiments, fn($s) => $s === 'neutral'));

            // Mettre à jour l'événement
            $event->average_rating = $averageRating;
            $event->rating_count = $ratingCount;
            $event->positive_feedbacks = $positive;
            $event->negative_feedbacks = $negative;
            $event->neutral_feedbacks = $neutral;
            $event->last_feedback_at = now();
            
            return $event->save();

        } catch (\Exception $e) {
            \Log::error('Erreur updateEventStats: ' . $e->getMessage());
            return false;
        }
    }
}