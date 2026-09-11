<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\CandidatureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role.custom:etudiant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'student'])->name('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

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

    // Submit a candidature for an offer
    Route::post('/candidatures', [CandidatureController::class, 'store'])
        ->name('candidatures.store');

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

    Route::get('/company-dashboard', [DashboardController::class, 'company'])
        ->name('company.dashboard');

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

Route::middleware('auth')->group(function () {
    Route::get('/student-profile', [StudentProfileController::class, 'show'])
        ->name('student-profile.show');

    Route::get('/student-profile/edit', [StudentProfileController::class, 'edit'])
        ->name('student-profile.edit');

    Route::put('/student-profile', [StudentProfileController::class, 'update'])
        ->name('student-profile.update');
    
    // Secure download route for student's own CV
    Route::get('/student-profile/cv', [StudentProfileController::class, 'downloadCv'])
        ->name('student-profile.cv');
});