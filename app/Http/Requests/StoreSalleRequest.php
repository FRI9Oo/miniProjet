<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('salle')?->id;

        return [
            'nom'        => ['required', 'string', 'max:100'],
            'code'       => ['required', 'string', 'max:20', 'unique:salles,code,' . $id],
            'capacite'   => ['required', 'integer', 'min:1', 'max:1000'],
            'type'       => ['required', 'in:cours,td,tp,amphi'],
            'disponible' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'      => 'Le nom de la salle est obligatoire.',
            'code.required'     => 'Le code de la salle est obligatoire.',
            'code.unique'       => 'Ce code est déjà utilisé par une autre salle.',
            'capacite.required' => 'La capacité est obligatoire.',
            'capacite.integer'  => 'La capacité doit être un nombre entier.',
            'capacite.min'      => 'La capacité doit être au moins 1.',
            'type.required'     => 'Le type de salle est obligatoire.',
            'type.in'           => 'Le type doit être : cours, td, tp ou amphi.',
        ];
    }
}