<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/test/etudiant', function () {
        return response('Accès étudiant autorisé', 200);
    })->name('test.etudiant');
});

Route::middleware(['auth', 'role:entreprise'])->group(function () {
    Route::get('/test/entreprise', function () {
        return response('Accès entreprise autorisé', 200);
    })->name('test.entreprise');
});

Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/test/administrateur', function () {
        return response('Accès administrateur autorisé', 200);
    })->name('test.administrateur');
});

require __DIR__.'/auth.php';
