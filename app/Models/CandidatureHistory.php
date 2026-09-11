<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidatureHistory extends Model
{
    use HasFactory;

    protected $table = 'candidature_histories';

    protected $fillable = [
        'candidature_id',
        'ancien_statut',
        'nouveau_statut',
        'date_changement',
    ];

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }
}
