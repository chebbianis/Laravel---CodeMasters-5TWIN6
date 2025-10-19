<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        Log::info('=== DEBUT FEEDBACK STORE ===', $request->all());

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'participant_name' => 'required|string|max:255',
            'participant_email' => 'required|email',
            'feedback' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        try {
            DB::beginTransaction();

            // Créer la participation feedback
            $participation = Participation::create([
                'event_id' => $validated['event_id'],
                'user_id' => null,
                'status' => 'confirmed', // ⭐ CHANGEMENT: utiliser un statut existant
                'notes' => json_encode([
                    'name' => $validated['participant_name'],
                    'email' => $validated['participant_email'],
                    'feedback' => $validated['feedback'],
                    'rating' => (int)$validated['rating'],
                    'submitted_at' => now()->toDateTimeString(),
                    'is_feedback' => true, // ⭐ NOUVEAU: marquer comme feedback
                ]),
                'registration_date' => now(),
            ]);

            Log::info('Participation créée:', ['id' => $participation->id]);

            // Analyser le sentiment
            $sentiment = $this->analyzeSentiment($validated['feedback']);
            Log::info('Sentiment analysé:', ['sentiment' => $sentiment]);

            // Mettre à jour les notes avec le sentiment
            $notes = json_decode($participation->notes, true);
            $notes['sentiment_analysis'] = $sentiment;
            $notes['analyzed_at'] = now()->toDateTimeString();
            $participation->update(['notes' => json_encode($notes)]);

            // Mettre à jour les stats de l'événement
            $this->updateEventStats($validated['event_id']);

            DB::commit();
            Log::info('=== FEEDBACK SUCCÈS ===');

            return back()->with('success', 'Merci pour votre avis ! Votre feedback a été enregistré.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERREUR FEEDBACK: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'enregistrement.');
        }
    }

    public function updateEventStats($eventId)
    {
        try {
            Log::info("Mise à jour des stats pour event: " . $eventId);
            
            $event = Event::find($eventId);
            if (!$event) {
                Log::error('Événement non trouvé: ' . $eventId);
                return;
            }

            // ⭐ CORRECTION: Chercher les feedbacks avec la nouvelle logique
            $feedbacks = Participation::where('event_id', $eventId)
                ->where('status', 'confirmed')
                ->where('notes', 'LIKE', '%"is_feedback":true%')
                ->get();

            Log::info("Feedbacks trouvés: " . $feedbacks->count());

            $ratings = [];
            $sentiments = [];

            foreach ($feedbacks as $feedback) {
                $notes = json_decode($feedback->notes, true);
                
                if (isset($notes['rating'])) {
                    $ratings[] = (int)$notes['rating'];
                    Log::info("Rating: " . $notes['rating']);
                }
                
                if (isset($notes['sentiment_analysis'])) {
                    $sentiments[] = $notes['sentiment_analysis'];
                    Log::info("Sentiment: " . $notes['sentiment_analysis']);
                }
            }

            // Calculer les stats
            $averageRating = count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 2) : 0;
            $ratingCount = count($ratings);
            $positive = count(array_filter($sentiments, fn($s) => $s === 'positive'));
            $negative = count(array_filter($sentiments, fn($s) => $s === 'negative'));
            $neutral = count(array_filter($sentiments, fn($s) => $s === 'neutral'));

            Log::info("Stats calculées: " . json_encode([
                'average' => $averageRating,
                'count' => $ratingCount,
                'positive' => $positive,
                'negative' => $negative,
                'neutral' => $neutral
            ]));

            // ⭐⭐ CORRECTION CRITIQUE: Assignation directe au lieu de update()
            $event->average_rating = $averageRating;
            $event->rating_count = $ratingCount;
            $event->positive_feedbacks = $positive;
            $event->negative_feedbacks = $negative;
            $event->neutral_feedbacks = $neutral;
            $event->last_feedback_at = now();
            
            $result = $event->save(); // ⭐ UTILISER save() au lieu de update()

            Log::info("Résultat sauvegarde: " . ($result ? 'SUCCÈS' : 'ÉCHEC'));
            Log::info("Valeurs sauvegardées - Rating: " . $averageRating . ", Count: " . $ratingCount);

            // Vérification immédiate
            $verifiedEvent = Event::find($eventId);
            Log::info("Vérification finale: " . json_encode([
                'average_rating' => $verifiedEvent->average_rating,
                'rating_count' => $verifiedEvent->rating_count
            ]));

        } catch (\Exception $e) {
            Log::error('Erreur updateEventStats: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
        }
    }

    private function analyzeSentiment($text)
    {
        $token = config('services.huggingface.api_key');
        
        if (!$token) {
            Log::warning('Token HuggingFace manquant');
            return 'neutral';
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment-latest', [
                'inputs' => $text,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result[0]) && isset($result[0][0])) {
                    return $result[0][0]['label'] ?? 'neutral';
                }
            }
        } catch (\Exception $e) {
            Log::error('Exception API: ' . $e->getMessage());
        }

        return 'neutral';
    }

    public function showEventFeedbacks($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        // ⭐ CORRECTION: Utiliser la nouvelle logique de recherche
        $feedbacks = Participation::where('event_id', $eventId)
            ->where('status', 'confirmed')
            ->where('notes', 'LIKE', '%"is_feedback":true%')
            ->get()
            ->map(function($participation) {
                $notes = json_decode($participation->notes, true);
                return [
                    'id' => $participation->id,
                    'name' => $notes['name'] ?? 'Anonyme',
                    'email' => $notes['email'] ?? '',
                    'feedback' => $notes['feedback'] ?? '',
                    'rating' => $notes['rating'] ?? 0,
                    'sentiment' => $notes['sentiment_analysis'] ?? 'non analysé',
                    'submitted_at' => $notes['submitted_at'] ?? $participation->created_at->format('d/m/Y H:i'),
                ];
            });

        return view('events.feedbacks', compact('event', 'feedbacks'));
    }
}