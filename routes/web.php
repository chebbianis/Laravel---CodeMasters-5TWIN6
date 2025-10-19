<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CollectionPointController;
use App\Http\Controllers\DepositController;

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
    Route::get('/catalog', [ItemController::class, 'catalogIndex'])->name('catalog.index');

    // Routes pour les objets (Items)
    Route::get('/catalog/items', [ItemController::class, 'index'])->name('catalog.items');
    Route::post('/catalog/items', [ItemController::class, 'store'])->name('catalog.items.store');
    Route::put('/catalog/items/{id}', [ItemController::class, 'update'])->name('catalog.items.update');
    Route::delete('/catalog/items/{id}', [ItemController::class, 'destroy'])->name('catalog.items.destroy');

    // Routes pour les catégories
    Route::get('/catalog/categories', [CategoryController::class, 'index'])->name('catalog.categories');
    Route::post('/catalog/categories', [CategoryController::class, 'store'])->name('catalog.categories.store');
    Route::put('/catalog/categories/{id}', [CategoryController::class, 'update'])->name('catalog.categories.update');
    Route::delete('/catalog/categories/{id}', [CategoryController::class, 'destroy'])->name('catalog.categories.destroy');

    // Page publique du catalogue (accessible aux utilisateurs connectés)
    Route::get('/catalogue', [ItemController::class, 'publicCatalog'])->name('catalog.public');

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

    Route::get('/collection-points/deposits', [DepositController::class, 'index'])->name('collection.deposits');


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

// Liste des points
Route::get('/collection-points/points', [CollectionPointController::class, 'points'])->name('collection.points');

// Formulaire de création
Route::get('/collection-points/create', [CollectionPointController::class, 'create'])->name('collection.create');

// Enregistrement d’un nouveau point
Route::post('/collection-points', [CollectionPointController::class, 'store'])->name('collection.store');

// Édition
Route::get('/collection-points/{collectionPoint}/edit', [CollectionPointController::class, 'edit'])->name('collection.edit');

// Mise à jour
Route::put('/collection-points/{collectionPoint}', [CollectionPointController::class, 'update'])->name('collection.update');

// Suppression
Route::delete('/collection-points/{collectionPoint}', [CollectionPointController::class, 'destroy'])->name('collection.destroy');

Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
Route::get('/deposits/create', [DepositController::class, 'create'])->name('deposits.create');
Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
Route::get('/deposits/{deposit}/edit', [DepositController::class, 'edit'])->name('deposits.edit');
Route::put('/deposits/{deposit}', [DepositController::class, 'update'])->name('deposits.update');
Route::delete('/deposits/{deposit}', [DepositController::class, 'destroy'])->name('deposits.destroy');
