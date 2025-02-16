<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    //? Vista Home con listado de cócteles de la API
    Route::get('/home', [CocktailController::class, 'index'])->name('home');

    //? Ruta para búsqueda de cócteles
    Route::get('/search', [CocktailController::class, 'search'])->name('search');

    //? Ruta para guardar cóctel favorito (acción AJAX)
    Route::post('/favorite', [CocktailController::class, 'storeFavorite'])->name('favorite.store');

    //? Rutas para CRUD de cócteles (Dashboard)
    Route::resource('cocktails', AdminCocktailController::class);
});

require __DIR__.'/auth.php';
