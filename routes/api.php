<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SentimentController;

Route::post('/analyze-sentiment', [SentimentController::class, 'analyze']);
Route::post('/events/{event}/analyze-feedback', [EventController::class, 'analyzeEventFeedback']);
Route::get('/events/sentiment-stats', [EventController::class, 'getSentimentStats']);