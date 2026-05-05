<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::withCount('matieres', 'emplois')->orderBy('nom')->paginate(10);
        return view('filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('filieres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => ['required', 'string', 'max:100'],
            'code'        => ['required', 'string', 'max:20', 'unique:filieres,code'],
            'semestre'    => ['required', 'integer', 'min:1', 'max:6'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Filiere::create($request->all());
        return redirect()->route('filieres.index')
            ->with('success', 'Filière ajoutée avec succès.');
    }

    public function show(Filiere $filiere)
    {
        $filiere->load('matieres', 'emplois.creneau', 'emplois.enseignant', 'emplois.salle', 'emplois.matiere');
        return view('filieres.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
    $salles = \App\Models\Salle::orderBy('nom')->get();
    return view('filieres.edit', compact('filiere', 'salles'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'nom'         => ['required', 'string', 'max:100'],
            'code'        => ['required', 'string', 'max:20', 'unique:filieres,code,' . $filiere->id],
            'semestre'    => ['required', 'integer', 'min:1', 'max:6'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $filiere->update($request->all());
        return redirect()->route('filieres.index')
            ->with('success', 'Filière modifiée avec succès.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return redirect()->route('filieres.index')
            ->with('success', 'Filière supprimée avec succès.');
    }
}