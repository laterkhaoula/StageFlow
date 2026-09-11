<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\StudentProfile;
use App\Policies\StudentProfilePolicy;
use App\Models\Offre;
use App\Policies\OffrePolicy;
use App\Models\Candidature;
use App\Policies\CandidaturePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register StudentProfile policy
        Gate::policy(StudentProfile::class, StudentProfilePolicy::class);
        // Register Offre and Candidature policies
        Gate::policy(Offre::class, OffrePolicy::class);
        Gate::policy(Candidature::class, CandidaturePolicy::class);
    }
}
