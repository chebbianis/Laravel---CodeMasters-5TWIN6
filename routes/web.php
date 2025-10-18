<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Page d'accueil avec login/inscription
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// Routes protégées - Authentification requise
// ==========================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal
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

    // Gestion des partenaires - Routes spécifiques AVANT la route resource
    Route::get('/partners', [App\Http\Controllers\PartnerController::class, 'index'])->name('partners.index');
    Route::get('/partners/list', [App\Http\Controllers\PartnerController::class, 'list'])->name('partners.list');
    Route::get('/partners/stats', [App\Http\Controllers\PartnerController::class, 'stats'])->name('partners.stats');
    Route::get('/partners/map', [App\Http\Controllers\PartnerController::class, 'map'])->name('partners.map');
    Route::get('/partners/data', [App\Http\Controllers\PartnerController::class, 'getPartnersData'])->name('partners.data');
    
    // Page publique des partenaires (accessible aux utilisateurs connectés)
    Route::get('/nos-partenaires', [App\Http\Controllers\PartnerController::class, 'publicPartners'])->name('partners.public');
    
    // Routes resource après les routes spécifiques
    Route::resource('partners', App\Http\Controllers\PartnerController::class)->except(['index']);

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
});

// ==========================
// Routes Admin uniquement
// ==========================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Gestion des utilisateurs et rôles
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/change-role', [UserController::class, 'changeRole'])->name('admin.users.change-role');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Gestion des types de partenaires (Admin uniquement)
    Route::get('/partners/types', [App\Http\Controllers\PartnerTypeController::class, 'index'])->name('partners.types');
    Route::resource('partner-types', App\Http\Controllers\PartnerTypeController::class)->except(['index']);
});
