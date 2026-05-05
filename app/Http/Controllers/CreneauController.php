<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use Illuminate\Http\Request;

class CreneauController extends Controller
{
    public function index()
    {
        $creneaux = Creneau::withoutGlobalScopes()
            ->orderByRaw('FIELD(jour,"Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi")')
            ->orderBy('heure_debut')
            ->get();
        return view('creneaux.index', compact('creneaux'));
    }

    public function create()
    {
        return view('creneaux.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jour'        => ['required', 'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin'   => ['required', 'date_format:H:i', 'after:heure_debut'],
            'libelle'     => ['nullable', 'string', 'max:100'],
        ], [
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ]);

        $exists = Creneau::withoutGlobalScopes()
            ->where('jour', $request->jour)
            ->where('heure_debut', $request->heure_debut)
            ->where('heure_fin', $request->heure_fin)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Ce créneau existe déjà pour ce jour.');
        }

        Creneau::create($request->all());
        return redirect()->route('creneaux.index')
            ->with('success', 'Créneau ajouté avec succès.');
    }

    public function show(Creneau $creneau)
    {
        $creneau->load('emplois.filiere', 'emplois.enseignant', 'emplois.salle', 'emplois.matiere');
        return view('creneaux.show', compact('creneau'));
    }

    public function edit(Creneau $creneau)
    {
        return view('creneaux.edit', compact('creneau'));
    }

    public function update(Request $request, Creneau $creneau)
    {
        $request->validate([
            'jour'        => ['required', 'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin'   => ['required', 'date_format:H:i', 'after:heure_debut'],
            'libelle'     => ['nullable', 'string', 'max:100'],
        ]);

        $creneau->update($request->all());
        return redirect()->route('creneaux.index')
            ->with('success', 'Créneau modifié avec succès.');
    }

    public function destroy(Creneau $creneau)
    {
        $creneau->delete();
        return redirect()->route('creneaux.index')
            ->with('success', 'Créneau supprimé avec succès.');
    }
}