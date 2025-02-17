<?php

use App\Http\Controllers\CocktailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminCocktailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/dashboard', [AdminCocktailController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    //? Vista Home con listado de cócteles de la API
    Route::get('/home', [CocktailController::class, 'index'])->name('home');

    //? Ruta para búsqueda de cócteles
    Route::get('/search', [CocktailController::class, 'search'])->name('search');
  
    //? Ruta para búsqueda de cócteles (acción AJAX)
    Route::get('/search/ajax', [CocktailController::class, 'ajaxSearch'])->name('search.ajax');

    //? Ruta para guardar cóctel favorito (acción AJAX)
    Route::post('/favorite', [CocktailController::class, 'storeFavorite'])->name('favorite.store');
 
    //? Vista para editar el perfil  y actualizarlo
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    //? Eliminar cuenta (DELETE)
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //? Actualizar contraseña (PUT)
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    //? Rutas para CRUD de cócteles (Dashboard)
    Route::resource('cocktails', AdminCocktailController::class);
});

require __DIR__.'/auth.php';
