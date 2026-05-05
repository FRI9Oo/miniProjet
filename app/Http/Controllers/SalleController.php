<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Http\Requests\StoreSalleRequest;

class SalleController extends Controller
{
    public function index()
    {
        $salles = Salle::orderBy('nom')->paginate(10);
        return view('salles.index', compact('salles'));
    }

    public function create()
    {
        return view('salles.create');
    }

    public function store(StoreSalleRequest $request)
    {
        Salle::create($request->validated());
        return redirect()->route('salles.index')
            ->with('success', 'Salle ajoutée avec succès.');
    }

    public function show(Salle $salle)
    {
        $salle->load('emplois.creneau', 'emplois.matiere', 'emplois.enseignant');
        return view('salles.show', compact('salle'));
    }

    public function edit(Salle $salle)
    {
        return view('salles.edit', compact('salle'));
    }

    public function update(StoreSalleRequest $request, Salle $salle)
    {
        $data = $request->validated();
        $data['disponible'] = $request->has('disponible'); // true if checked, false if not
        
        $salle->update($data);
        return redirect()->route('salles.index')
            ->with('success', 'Salle modifiée avec succès.');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();
        return redirect()->route('salles.index')
            ->with('success', 'Salle supprimée avec succès.');
    }
}