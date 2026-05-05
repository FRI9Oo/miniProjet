<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatiereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('matiere')?->id;

        return [
            'nom'            => ['required', 'string', 'max:150'],
            'code'           => ['required', 'string', 'max:20', 'unique:matieres,code,' . $id],
            'volume_horaire' => ['required', 'numeric', 'min:1', 'max:500'],
            'type'           => ['required', 'in:cours,td,tp'],
            'filiere_id'     => ['nullable', 'integer', 'exists:filieres,id'],
            'filieres'       => ['nullable', 'array'],
            'filieres.*'     => ['integer', 'exists:filieres,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'            => 'Le nom de la matière est obligatoire.',
            'code.required'           => 'Le code de la matière est obligatoire.',
            'code.unique'             => 'Ce code est déjà utilisé par une autre matière.',
            'volume_horaire.required' => 'Le volume horaire est obligatoire.',
            'volume_horaire.numeric'  => 'Le volume horaire doit être un nombre.',
            'volume_horaire.min'      => 'Le volume horaire doit être au moins 1 heure.',
            'type.required'           => 'Le type est obligatoire.',
            'type.in'                 => 'Le type doit être : cours, td ou tp.',
            'filiere_id.exists'       => 'La filière sélectionnée n\'existe pas.',
            'filieres.*.exists'       => 'Une des filières sélectionnées n\'existe pas.',
        ];
    }
}