<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Filiere;
use App\Http\Requests\StoreMatiereRequest;

class MatiereController extends Controller
{
    public function index()
    {
        $matieres = Matiere::with('filiere')->orderBy('nom')->paginate(10);
        return view('matieres.index', compact('matieres'));
    }

    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();
        return view('matieres.create', compact('filieres'));
    }

    public function store(StoreMatiereRequest $request)
    {
        $data = $request->validated();
        $filieres = $data['filieres'] ?? [];
        unset($data['filieres']);
        
        // Set filiere_id for backward compatibility
        $data['filiere_id'] = $filieres[0] ?? null;
        
        $matiere = Matiere::create($data);
        $matiere->filieres()->sync($filieres);
        
        return redirect()->route('matieres.index')
            ->with('success', 'Matière ajoutée avec succès.');
    }


    public function show(Matiere $matiere)
    {
        $matiere->load('filiere', 'emplois.creneau', 'emplois.enseignant', 'emplois.salle');
        return view('matieres.show', compact('matiere'));
    }

    public function edit(Matiere $matiere)
    {
        $filieres = Filiere::orderBy('nom')->get();
        return view('matieres.edit', compact('matiere', 'filieres'));
    }

    public function update(StoreMatiereRequest $request, Matiere $matiere)
    {
        $data = $request->validated();
        $filieres = $data['filieres'] ?? [];
        unset($data['filieres']);
        
        // Set filiere_id for backward compatibility
        $data['filiere_id'] = $filieres[0] ?? $matiere->filiere_id;
        
        $matiere->update($data);
        $matiere->filieres()->sync($filieres);
        
        return redirect()->route('matieres.index')
            ->with('success', 'Matière modifiée avec succès.');
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();
        return redirect()->route('matieres.index')
            ->with('success', 'Matière supprimée avec succès.');
    }
}