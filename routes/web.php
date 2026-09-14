<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
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

    // Consultation des offres actives (étudiants et entreprises)
    Route::get('/offres', [OffreController::class, 'index'])->name('offres.index');

    Route::get('/offres/{offre}', [OffreController::class, 'show'])->name('offres.show');
});

/*
|--------------------------------------------------------------------------
| Routes Étudiant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.custom:etudiant'])->group(function () {

    Route::get('/candidatures', [CandidatureController::class, 'index'])
        ->name('candidatures.index');

    Route::post('/candidatures', [CandidatureController::class, 'store'])
        ->name('candidatures.store');

    Route::get('/student-profile', [StudentProfileController::class, 'show'])
        ->name('student-profile.show');

    Route::get('/student-profile/edit', [StudentProfileController::class, 'edit'])
        ->name('student-profile.edit');

    Route::put('/student-profile', [StudentProfileController::class, 'update'])
        ->name('student-profile.update');

    Route::get('/student-profile/cv', [StudentProfileController::class, 'downloadCv'])
        ->name('student-profile.cv');

});

/*
|--------------------------------------------------------------------------
| Routes Entreprise
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.custom:entreprise'])->group(function () {

    Route::get('/company-dashboard', [DashboardController::class, 'company'])
        ->name('company.dashboard');

    Route::get('/company-profile', [CompanyProfileController::class, 'show'])
        ->name('company-profile.show');

    Route::get('/company-profile/edit', [CompanyProfileController::class, 'edit'])
        ->name('company-profile.edit');

    Route::put('/company-profile', [CompanyProfileController::class, 'update'])
        ->name('company-profile.update');

    // Gestion des offres de l'entreprise
    Route::get('/mes-offres', [OffreController::class, 'companyIndex'])->name('offres.company.index');

    Route::get('/mes-offres/create', [OffreController::class, 'create'])->name('offres.company.create');

    Route::post('/mes-offres', [OffreController::class, 'store'])->name('offres.company.store');

    Route::get('/mes-offres/{offre}/edit', [OffreController::class, 'edit'])->name('offres.company.edit');

    Route::put('/mes-offres/{offre}', [OffreController::class, 'update'])->name('offres.company.update');

    Route::put('/mes-offres/{offre}/statut', [OffreController::class, 'toggleStatus'])->name('offres.company.toggle');

    Route::delete('/mes-offres/{offre}', [OffreController::class, 'destroy'])->name('offres.company.destroy');

    // Gestion des candidatures reçues
    Route::get('/mes-candidatures', [CandidatureController::class, 'companyIndex'])->name('candidatures.company.index');

    Route::get('/mes-candidatures/{candidatureId}', [CandidatureController::class, 'companyShow'])->name('candidatures.company.show');

    Route::get('/mes-candidatures/{candidatureId}/cv', [CandidatureController::class, 'companyDownloadCv'])->name('candidatures.company.cv');

    Route::post('/mes-candidatures/{candidatureId}/accept', [CandidatureController::class, 'companyAccept'])->name('candidatures.company.accept');

    Route::post('/mes-candidatures/{candidatureId}/refuse', [CandidatureController::class, 'companyRefuse'])->name('candidatures.company.refuse');

});

/*
|--------------------------------------------------------------------------
| Routes Administrateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role.custom:administrateur'])->group(function () {

    Route::get('/admin-dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'users'])
        ->name('admin.users');

    Route::get('/admin/offres', [AdminController::class, 'offres'])
        ->name('admin.offres');

    Route::get('/admin/candidatures', [AdminController::class, 'candidatures'])
        ->name('admin.candidatures');

});

require __DIR__.'/auth.php';