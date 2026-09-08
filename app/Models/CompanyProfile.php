<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom_entreprise',
        'secteur',
        'contact',
        'description',
    ];

    /**
     * The user who owns this company profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}