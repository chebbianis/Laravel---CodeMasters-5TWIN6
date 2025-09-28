<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerTypeController;

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

// Pages publiques
Route::get('/nos-partenaires', [App\Http\Controllers\PartnerController::class, 'publicPartners'])->name('partners.public');
Route::get('/about', function () {
    return redirect()->route('home');
})->name('about');

// Gestion des partenaires - Routes spécifiques AVANT la route resource
Route::get('/partners', [App\Http\Controllers\PartnerController::class, 'index'])->name('partners.index');
Route::get('/partners/list', [App\Http\Controllers\PartnerController::class, 'list'])->name('partners.list');
Route::get('/partners/data', [App\Http\Controllers\PartnerController::class, 'getPartnersData'])->name('partners.data');
Route::get('/partners/types', [App\Http\Controllers\PartnerTypeController::class, 'index'])->name('partners.types');

// Routes resource après les routes spécifiques
Route::resource('partners', App\Http\Controllers\PartnerController::class)->except(['index']);

// Gestion des types de partenaires
Route::resource('partner-types', App\Http\Controllers\PartnerTypeController::class)->except(['index']);

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
Route::get('/events', function () {
    return view('events.index');
})->name('events.index');

Route::get('/events/workshops', function () {
    return view('events.workshops');
})->name('events.workshops');

Route::get('/events/participations', function () {
    return view('events.participations');
})->name('events.participations');
