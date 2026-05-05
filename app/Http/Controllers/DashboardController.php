<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Enseignant;
use App\Models\Salle;
use App\Models\Filiere;

class DashboardController extends Controller
{
    public function index()
    {
        $coursParJour = EmploiDuTemps::join('creneaux', 'creneaux.id', '=', 'emplois_du_temps.creneau_id')
            ->selectRaw('creneaux.jour, count(*) as total')
            ->groupBy('creneaux.jour')
            ->pluck('total', 'creneaux.jour');

        $coursParFiliere = EmploiDuTemps::join('filieres', 'filieres.id', '=', 'emplois_du_temps.filiere_id')
            ->selectRaw('filieres.nom, count(*) as total')
            ->groupBy('filieres.nom')
            ->pluck('total', 'filieres.nom');

        $stats = [
            'enseignants' => Enseignant::count(),
            'salles'      => Salle::count(),
            'filieres'    => Filiere::count(),
            'cours'       => EmploiDuTemps::count(),
        ];

        $recentEmplois = EmploiDuTemps::with('matiere', 'enseignant', 'filiere', 'creneau')
            ->latest()
            ->take(5)
            ->get();
        $recentActivities = \App\Models\ActivityLog::with('emploi.matiere', 'emploi.enseignant', 'emploi.filiere', 'emploi.salle', 'emploi.creneau')
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard', compact('coursParJour', 'coursParFiliere', 'stats', 'recentEmplois', 'recentActivities'));
    }
}