<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_entreprise_id',
        'titre',
        'description',
        'domaine',
        'localisation',
        'date_publication',
        'statut',
    ];

    /**
     * The company profile that published the offer.
     */
    public function companyProfile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class, 'profil_entreprise_id');
    }

    /**
     * The applications for this offer.
     */
    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }
}