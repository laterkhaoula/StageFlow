<?php

use App\Http\Controllers\OffreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Étudiant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.custom:etudiant'])->group(function () {

    Route::get('/test/etudiant', function () {
        return response('Accès étudiant autorisé', 200);
    })->name('test.etudiant');

});

/*
|--------------------------------------------------------------------------
| Routes Entreprise
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.custom:entreprise'])->group(function () {

    Route::get('/test/entreprise', function () {
        return response('Accès entreprise autorisé', 200);
    })->name('test.entreprise');

    Route::resource('offres', OffreController::class);

});

/*
|--------------------------------------------------------------------------
| Routes Administrateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.custom:administrateur'])->group(function () {

    Route::get('/test/administrateur', function () {
        return response('Accès administrateur autorisé', 200);
    })->name('test.administrateur');

});

require __DIR__.'/auth.php';