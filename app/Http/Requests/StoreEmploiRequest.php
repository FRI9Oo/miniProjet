<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\EmploiDuTemps;

class StoreEmploiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // On update, exclude the current record from conflict checks
        $id = $this->route('emploi_du_temp') ?? $this->route('emploi');

        return [
            'filiere_id'     => ['required', 'exists:filieres,id'],
            'enseignant_id'  => [
                'required',
                'exists:enseignants,id',
                // Enseignant cannot be booked twice at the same slot
                Rule::unique('emplois_du_temps')
                    ->where('creneau_id', $this->creneau_id)
                    ->ignore($id),
            ],
            'salle_id'       => [
                'required',
                'exists:salles,id',
                // Same room cannot host two groups at same slot
                Rule::unique('emplois_du_temps')
                    ->where('creneau_id', $this->creneau_id)
                    ->ignore($id),
            ],
            'matiere_id'     => ['required', 'exists:matieres,id'],
            'creneau_id'     => [
                'required',
                'exists:creneaux,id',
                // Same filiere cannot have two courses at same slot
                Rule::unique('emplois_du_temps')
                    ->where('filiere_id', $this->filiere_id)
                    ->ignore($id),
            ],
            'notes'          => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'filiere_id.required'    => 'La filière est obligatoire.',
            'filiere_id.exists'      => 'La filière sélectionnée n\'existe pas.',
            'enseignant_id.required' => 'L\'enseignant est obligatoire.',
            'enseignant_id.exists'   => 'L\'enseignant sélectionné n\'existe pas.',
            'enseignant_id.unique'   => 'Conflit : cet enseignant est déjà assigné à ce créneau.',
            'salle_id.required'      => 'La salle est obligatoire.',
            'salle_id.exists'        => 'La salle sélectionnée n\'existe pas.',
            'salle_id.unique'        => 'Conflit : cette salle est déjà occupée à ce créneau.',
            'matiere_id.required'    => 'La matière est obligatoire.',
            'matiere_id.exists'      => 'La matière sélectionnée n\'existe pas.',
            'creneau_id.required'    => 'Le créneau est obligatoire.',
            'creneau_id.exists'      => 'Le créneau sélectionné n\'existe pas.',
            'creneau_id.unique'      => 'Conflit : cette filière a déjà un cours à ce créneau.',
        ];
    }
}