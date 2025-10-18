<?php
use App\Http\Controllers\ImageDetectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Models\Item;
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

// Catalogue des objets valorables
Route::get('/catalog', function() {
    return redirect()->route('items.index');
})->name('catalog.index');



// Items
Route::resource('items', ItemController::class);

Route::get('/item', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/item', [ItemController::class, 'store'])->name('items.store');
Route::get('/item/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/item/{item}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/item/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
// Catalogue - Items
Route::get('/catalogue', [HomeController::class, 'catalogueUser'])->name('catalogue');



// Catalogue - Categories
Route::resource('categories', CategoryController::class);
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{id}/items', [ItemController::class, 'itemsByCategory'])
     ->name('categories.items');
Route::get('/categories/{category}/items', [CategoryController::class, 'showItems'])
     ->name('categories.items');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
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
// dans routes/web.php
