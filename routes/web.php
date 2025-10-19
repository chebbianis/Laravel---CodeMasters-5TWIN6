<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\FeedbackController; // ⭐ IMPORTANT
use App\Models\Event;

// Page d'accueil avec login/inscription
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes d'authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Dashboard principal après connexion
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Gestion du catalogue des objets valorables
Route::get('/catalog', function () {
    return view('catalog.index');
})->name('catalog.index');

Route::get('/catalog/items', function () {
    return view('catalog.items');
})->name('catalog.items');

Route::get('/catalog/categories', function () {
    return view('catalog.categories');
})->name('catalog.categories');

// Gestion des partenaires
Route::get('/partners', function () {
    return view('partners.index');
})->name('partners.index');

Route::get('/partners/list', function () {
    return view('partners.list');
})->name('partners.list');

Route::get('/partners/types', function () {
    return view('partners.types');
})->name('partners.types');

// Gestion des points de collecte
Route::get('/collection-points', function () {
    return view('collection.index');
})->name('collection.index');

Route::get('/collection-points/points', function () {
    return view('collection.points');
})->name('collection.points');

Route::get('/collection-points/deposits', function () {
    return view('collection.deposits');
})->name('collection.deposits');

// Gestion des événements et ateliers
Route::get('events/workshops', [EventController::class, 'workshops'])->name('events.workshops');
Route::get('events/participations', [EventController::class, 'participations'])->name('events.participations');
Route::post('/participations', [ParticipationController::class, 'store'])->name('participations.store');
Route::delete('/participations/{participation}', [ParticipationController::class, 'destroy'])->name('participations.destroy');

Route::get('/evenements', [EventController::class, 'eventsFront'])->name('events-front');

// Routes liées aux événements
Route::prefix('events')->group(function () {
    Route::get('participations', [EventController::class, 'participations'])->name('events.participations');

// Routes d'export
Route::get('/events/export/{format}', [EventController::class, 'export'])->name('events.export');
Route::get('/participations/export/{format}', [EventController::class, 'exportParticipations'])->name('participations.export');
 // Route newsletter (optionnelle)
 Route::get('participations/newsletter', [EventController::class, 'newsletter'])->name('events.participations.newsletter');
});

// ⚡ Ajout des routes pour confirmer / annuler une participation
Route::prefix('participations')->group(function () {
    Route::post('{participation}/confirm', [ParticipationController::class, 'confirm'])->name('participations.confirm');
    Route::post('{participation}/cancel', [ParticipationController::class, 'cancel'])->name('participations.cancel');
});

// Routes pour l'analyse de sentiment
Route::post('/events/{event}/analyze-feedback', [EventController::class, 'analyzeEventFeedback'])->name('events.analyze-feedback');
Route::get('/events/sentiment-stats', [EventController::class, 'getSentimentStats'])->name('events.sentiment-stats');
Route::post('/events/analyze-all', [EventController::class, 'analyzeAllEvents'])->name('events.analyze-all');
Route::post('/participations/{participation}/add-feedback', [ParticipationController::class, 'addFeedback'])->name('participations.add-feedback');
Route::post('/participations/{participation}/analyze-feedback', [ParticipationController::class, 'analyzeParticipantFeedback'])->name('participations.analyze-feedback');

// ⭐⭐ ROUTES POUR LES FEEDBACKS (CORRIGÉ)
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/events/{event}/feedbacks', [FeedbackController::class, 'showEventFeedbacks'])->name('events.feedbacks');

// Resource events
Route::resource('events', EventController::class)->except(['edit']);