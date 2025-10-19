<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentimentController extends Controller
{
    public function analyze(Request $request)
    {
        $text = $request->input('text');

        if (!$text) {
            return response()->json(['error' => 'Le texte est requis'], 400);
        }

        $token = config('services.huggingface.api_key');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment-latest', [
                'inputs' => $text,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                // ⭐⭐ CORRECTION ICI ⭐⭐
                // Le modèle retourne un tableau de résultats, on prend le premier
                $firstResult = $result[0][0] ?? null;
                
                if ($firstResult) {
                    return response()->json([
                        'success' => true,
                        'sentiment' => $firstResult['label'] ?? 'unknown',
                        'confidence' => $firstResult['score'] ?? 0,
                        'text_analyzed' => $text
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Structure de réponse inattendue',
                        'raw_response' => $result
                    ], 500);
                }
            } else {
                return response()->json([
                    'error' => 'Erreur API HuggingFace',
                    'status' => $response->status(),
                    'message' => $response->body()
                ], $response->status());
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur de connexion: ' . $e->getMessage()
            ], 500);
        }
    }
}