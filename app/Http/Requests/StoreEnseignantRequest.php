<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // On update, ignore the current record's unique email check
        $id = $this->route('enseignant')?->id;

        return [
            'nom'        => ['required', 'string', 'max:100'],
            'prenom'     => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:enseignants,email,' . $id],
            'telephone'  => ['nullable', 'string', 'max:20'],
            'specialite' => ['nullable', 'string', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'     => 'Le nom est obligatoire.',
            'prenom.required'  => 'Le prénom est obligatoire.',
            'email.required'   => 'L\'email est obligatoire.',
            'email.email'      => 'L\'email doit être une adresse valide.',
            'email.unique'     => 'Cet email est déjà utilisé par un autre enseignant.',
        ];
    }
}