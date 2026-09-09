<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_etudiant_id',
        'offre_id',
        'message_motivation',
        'date_candidature',
        'statut',
    ];

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class, 'profil_etudiant_id');
    }

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
    }
}