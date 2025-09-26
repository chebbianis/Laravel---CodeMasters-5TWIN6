<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/events', function () {
    return view('events.index');
})->name('events.index');

Route::get('/events/workshops', function () {
    return view('events.workshops');
})->name('events.workshops');

Route::get('/events/participations', function () {
    return view('events.participations');
})->name('events.participations');
