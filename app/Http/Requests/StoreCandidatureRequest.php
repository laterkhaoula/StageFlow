<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'offre_id' => ['required', 'integer', 'exists:offres,id'],
            'message_motivation' => ['required', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'offre_id.required' => "L'identifiant de l'offre est requis.",
            'offre_id.exists' => "Cette offre n'existe pas.",
            'message_motivation.required' => 'Le message de motivation est obligatoire.',
            'message_motivation.max' => 'Le message de motivation ne peut pas dépasser 5000 caractères.',
        ];
    }
}
