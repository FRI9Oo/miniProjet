<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Http\Requests\StoreEnseignantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class EnseignantController extends Controller
{
    // List all enseignants
    public function index()
    {
        $enseignants = Enseignant::orderBy('nom')->paginate(10);
        return view('enseignants.index', compact('enseignants'));
    }

    // Show create form
    public function create()
    {
        return view('enseignants.create');
    }

    // Store new enseignant + create user account + send password reset
    public function store(StoreEnseignantRequest $request)
    {
        $user = \App\Models\User::create([
            'name'     => $request->prenom . ' ' . $request->nom,
            'email'    => $request->email,
            'password' => Hash::make(Str::random(32)),
            'role'     => 'enseignant',
        ]);

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $enseignant = Enseignant::create($data);

        $user->update(['enseignant_id' => $enseignant->id]);

        Password::sendResetLink(['email' => $user->email]);

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant créé avec succès. Un email de définition de mot de passe a été envoyé à ' . $user->email);
    }

    // Show single enseignant
    public function show(Enseignant $enseignant)
    {
        $enseignant->load('emplois.matiere', 'emplois.salle', 'emplois.creneau');
        return view('enseignants.show', compact('enseignant'));
    }

    // Show edit form
    public function edit(Enseignant $enseignant)
    {
        return view('enseignants.edit', compact('enseignant'));
    }

    // Update enseignant
    public function update(StoreEnseignantRequest $request, Enseignant $enseignant)
    {
        $enseignant->update($request->validated());
        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant modifié avec succès.');
    }

    // Delete enseignant
    public function destroy(Enseignant $enseignant)
    {
        // Delete the linked user account
        if ($enseignant->user_id) {
            \App\Models\User::where('id', $enseignant->user_id)->delete();
        }

        $enseignant->delete();

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant et son compte utilisateur supprimés avec succès.');
    }

    public function planning()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Les administrateurs n\'ont pas de planning personnel.');
        }

        $enseignant = Enseignant::findOrFail(auth()->user()->enseignant_id);

        $creneaux = \App\Models\Creneau::withoutGlobalScopes()
            ->orderByRaw(\App\Models\Creneau::getDayOrderClause())
            ->orderBy('heure_debut')
            ->get()
            ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $emplois = \App\Models\EmploiDuTemps::with(['matiere', 'filiere', 'salle', 'creneau'])
            ->where('enseignant_id', $enseignant->id)
            ->get();

        $grid = [];
        foreach ($emplois as $emploi) {
            $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
        }

        return view('enseignants.planning', compact('enseignant', 'creneaux', 'jours', 'grid'));
    }

    public function exportPlanning()
    {
        $enseignant = Enseignant::findOrFail(auth()->user()->enseignant_id);

        $creneaux = \App\Models\Creneau::withoutGlobalScopes()
            ->orderByRaw(\App\Models\Creneau::getDayOrderClause())
            ->orderBy('heure_debut')
            ->get()
            ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $emplois = \App\Models\EmploiDuTemps::with(['matiere', 'filiere', 'salle', 'creneau'])
            ->where('enseignant_id', $enseignant->id)
            ->get();

        $grid = [];
        foreach ($emplois as $emploi) {
            $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
        }

        return view('enseignants.export', compact('enseignant', 'creneaux', 'jours', 'grid'));
    }
}