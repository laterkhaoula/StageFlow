<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'domaine' => ['required', 'string', 'max:255'],
            'localisation' => ['required', 'string', 'max:255'],
            'date_publication' => ['required', 'date'],
            'statut' => ['required', 'string', 'in:ouverte,fermee'],
        ];
    }
}
