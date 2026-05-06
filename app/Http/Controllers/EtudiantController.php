<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Filiere;
use App\Models\Creneau;

class EtudiantController extends Controller
{
    // -------------------------------------------------------
    // STUDENT INDEX — pick a filiere to view
    // -------------------------------------------------------
    public function index()
    {
        $user = auth()->user();

        // If student is linked to a filiere, redirect straight to their timetable
        if ($user->isEtudiant() && $user->filiere_id) {
            return redirect()->route('etudiant.emploi.show', $user->filiere_id);
        }

        // Otherwise show filiere picker (admin or unlinked student)
        $filieres = Filiere::withCount('emplois')->orderBy('nom')->get();
        return view('etudiant.index', compact('filieres'));
    }

    // -------------------------------------------------------
    // STUDENT SHOW — read-only timetable grid for one filiere
    // -------------------------------------------------------
    public function show(Filiere $filiere)
    {
        $jours    = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $filieres = Filiere::orderBy('nom')->get();

        $creneaux = Creneau::withoutGlobalScopes()
            ->orderByRaw(Creneau::getDayOrderClause())
            ->orderBy('heure_debut')
            ->get()
            ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

        $emplois = EmploiDuTemps::with('enseignant', 'salle', 'matiere', 'creneau')
            ->where('filiere_id', $filiere->id)
            ->get();

        // Build grid lookup [jour][heure_debut] => emploi
        $grid = [];
        foreach ($emplois as $emploi) {
            $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
        }

        return view('etudiant.show', compact('filiere', 'filieres', 'creneaux', 'jours', 'grid'));
    }

    // -------------------------------------------------------
    // TEACHER PLANNING — personal schedule for logged-in enseignant
    // -------------------------------------------------------
    public function planning()
    {
        $user = auth()->user();
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        // Admin sees a picker, enseignant sees their own schedule
        if ($user->isAdmin()) {
            $emplois  = EmploiDuTemps::with('filiere', 'enseignant', 'salle', 'matiere', 'creneau')
                ->orderBy('filiere_id')
                ->get();

            $creneaux = Creneau::withoutGlobalScopes()
                ->orderByRaw(Creneau::getDayOrderClause())
                ->orderBy('heure_debut')
                ->get()
                ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

            $grid = [];
            foreach ($emplois as $emploi) {
                $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut][] = $emploi;
            }

            return view('etudiant.planning', compact('emplois', 'creneaux', 'jours', 'grid'));
        }

        // Enseignant — filter by their profile
        if (!$user->enseignant_id) {
            return view('etudiant.planning_no_profile');
        }

        $creneaux = Creneau::withoutGlobalScopes()
            ->orderByRaw(Creneau::getDayOrderClause())
            ->orderBy('heure_debut')
            ->get()
            ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

        $emplois = EmploiDuTemps::with('filiere', 'salle', 'matiere', 'creneau')
            ->where('enseignant_id', $user->enseignant_id)
            ->get();

        $grid = [];
        foreach ($emplois as $emploi) {
            $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
        }

        $enseignant = $user->enseignant;

        return view('etudiant.planning', compact('enseignant', 'creneaux', 'jours', 'grid'));
    }
    public function export()
{
    $user = auth()->user();
    $filiere = \App\Models\Filiere::findOrFail($user->filiere_id);

    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    $creneaux = \App\Models\Creneau::withoutGlobalScopes()
        ->orderByRaw(\App\Models\Creneau::getDayOrderClause())
        ->orderBy('heure_debut')
        ->get()
        ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

    $emplois = \App\Models\EmploiDuTemps::with(['matiere', 'enseignant', 'salle', 'creneau'])
        ->where('filiere_id', $filiere->id)
        ->get();

    $grid = [];
    foreach ($emplois as $emploi) {
        $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
    }

    return view('etudiant.export', compact('filiere', 'creneaux', 'jours', 'grid'));
}
}   