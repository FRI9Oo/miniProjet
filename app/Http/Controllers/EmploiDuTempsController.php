<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Filiere;
use App\Models\Enseignant;
use App\Models\Salle;
use App\Models\Matiere;
use App\Models\Creneau;
use App\Http\Requests\StoreEmploiRequest;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    // -------------------------------------------------------
    // INDEX — list all entries grouped by filiere
    // -------------------------------------------------------
    public function index()
    {
        $emplois  = EmploiDuTemps::with('filiere','enseignant','salle','matiere','creneau')
                        ->orderBy('filiere_id')
                        ->paginate(15);
        $filieres = Filiere::orderBy('nom')->get();
        return view('emplois.index', compact('emplois', 'filieres'));
    }

    // -------------------------------------------------------
    // CREATE — show form
    // -------------------------------------------------------
    public function create()
    {
        $filieres    = Filiere::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $salles      = Salle::disponible()->orderBy('nom')->get();
        $matieres    = Matiere::with('filieres')->orderBy('nom')->get();
        $creneaux    = Creneau::withoutGlobalScopes()
                        ->orderByRaw(Creneau::getDayOrderClause())
                        ->orderBy('heure_debut')
                        ->get();

        return view('emplois.create', compact(
            'filieres','enseignants','salles','matieres','creneaux'
        ));
    }

    // -------------------------------------------------------
    // STORE — save + conflict check
    // -------------------------------------------------------
    public function store(StoreEmploiRequest $request)
    {
        // Double-check conflicts in controller as safety net
        $conflict = $this->checkConflicts(
            $request->filiere_id,
            $request->enseignant_id,
            $request->salle_id,
            $request->creneau_id
        );

        if ($conflict) {
            return back()->withInput()->with('error', $conflict);
        }

        $emploi = EmploiDuTemps::create($request->validated());

        \App\Models\ActivityLog::create([
            'action' => 'created',
            'description' => $emploi->matiere->nom . ' — ' . $emploi->enseignant->nom_complet . ' — ' . $emploi->filiere->code . ' — ' . $emploi->creneau->jour . ' ' . substr($emploi->creneau->heure_debut,0,5) . '-' . substr($emploi->creneau->heure_fin,0,5) . ' — ' . $emploi->salle->code,
            'emploi_id' => $emploi->id,
        ]);

return redirect()->route('emplois.index')
    ->with('success', 'Cours ajouté à l\'emploi du temps.');
    }

    // -------------------------------------------------------
    // SHOW — single entry detail
    // -------------------------------------------------------
    public function show(EmploiDuTemps $emploi)
    {
        $emploi->load('filiere','enseignant','salle','matiere','creneau');
        return view('emplois.show', compact('emploi'));
    }

    // -------------------------------------------------------
    // EDIT
    // -------------------------------------------------------
    public function edit(EmploiDuTemps $emploi)
    {
        $filieres    = Filiere::orderBy('nom')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        $salles      = Salle::where(function ($query) use ($emploi) {
                            $query->where('disponible', true)
                                ->orWhere('id', $emploi->salle_id);
                        })->orderBy('nom')->get();
        $matieres    = Matiere::with('filieres')->orderBy('nom')->get();
        $creneaux    = Creneau::withoutGlobalScopes()
                        ->orderByRaw(Creneau::getDayOrderClause())
                        ->orderBy('heure_debut')
                        ->get();

        return view('emplois.edit', compact(
            'emploi','filieres','enseignants','salles','matieres','creneaux'
        ));
    }

    // -------------------------------------------------------
    // UPDATE
    // -------------------------------------------------------
    public function update(StoreEmploiRequest $request, EmploiDuTemps $emploi)
    {
        $conflict = $this->checkConflicts(
            $request->filiere_id,
            $request->enseignant_id,
            $request->salle_id,
            $request->creneau_id,
            $emploi->id
        );

        if ($conflict) {
            return back()->withInput()->with('error', $conflict);
        }

        $emploi->update($request->validated());

\App\Models\ActivityLog::create([
    'action' => 'updated',
    'description' => $emploi->matiere->nom . ' — ' . $emploi->enseignant->nom_complet . ' — ' . $emploi->filiere->code . ' — ' . $emploi->creneau->jour . ' ' . substr($emploi->creneau->heure_debut,0,5) . '-' . substr($emploi->creneau->heure_fin,0,5) . ' — ' . $emploi->salle->code,
    'emploi_id' => $emploi->id,
]);

return redirect()->route('emplois.filiere', $request->filiere_id)
    ->with('success', 'Cours modifié avec succès.');
    }

    // -------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------
    public function destroy(EmploiDuTemps $emploi)
    {
        \App\Models\ActivityLog::create([
    'action' => 'deleted',
    'description' => $emploi->matiere->nom . ' — ' . $emploi->enseignant->nom_complet . ' — ' . $emploi->filiere->code . ' — ' . $emploi->creneau->jour . ' ' . substr($emploi->creneau->heure_debut,0,5) . '-' . substr($emploi->creneau->heure_fin,0,5) . ' — ' . $emploi->salle->code,
    'emploi_id' => $emploi->id,
]);
        
        $filiereId = $emploi->filiere_id;
        $emploi->delete();
        return redirect()->route('emplois.filiere', $filiereId)
            ->with('success', 'Cours supprimé avec succès.');
    }

    // -------------------------------------------------------
    // BY FILIERE — weekly grid view for admin
    // -------------------------------------------------------
    public function byFiliere(Filiere $filiere)
    {
        $jours    = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $creneaux = Creneau::withoutGlobalScopes()
                        ->orderByRaw(Creneau::getDayOrderClause())
                        ->orderBy('heure_debut')
                        ->get()
                        ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

        $emplois = EmploiDuTemps::with('enseignant','salle','matiere','creneau')
                        ->where('filiere_id', $filiere->id)
                        ->get();

        // Build lookup: [jour][heure_debut] => emploi
        $grid = [];
        foreach ($emplois as $emploi) {
            $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
        }

        $filieres = Filiere::orderBy('nom')->get();
        return view('emplois.grid', compact('filiere','filieres','creneaux','jours','grid'));
    }

    // -------------------------------------------------------
    // EXPORT — print-friendly timetable for a filiere
    // -------------------------------------------------------
    public function export(Filiere $filiere)
    {
        $jours    = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $creneaux = Creneau::withoutGlobalScopes()
                        ->orderByRaw(Creneau::getDayOrderClause())
                        ->orderBy('heure_debut')
                        ->get()
                        ->unique(fn($c) => $c->heure_debut . '-' . $c->heure_fin);

        $emplois = EmploiDuTemps::with('enseignant','salle','matiere','creneau')
                        ->where('filiere_id', $filiere->id)
                        ->get();

        $grid = [];
        foreach ($emplois as $emploi) {
            $grid[$emploi->creneau->jour][$emploi->creneau->heure_debut] = $emploi;
        }

        return view('emplois.export', compact('filiere','creneaux','jours','grid'));
    }

    // -------------------------------------------------------
    // PRIVATE — conflict checker
    // -------------------------------------------------------
    private function checkConflicts(
        int $filiereId,
        int $enseignantId,
        int $salleId,
        int $creneauId,
        ?int $excludeId = null
    ): ?string {
        if (EmploiDuTemps::enseignantConflict($enseignantId, $creneauId, $excludeId)) {
            $enseignant = Enseignant::find($enseignantId);
            return "Conflit : {$enseignant->nom_complet} est déjà assigné à ce créneau.";
        }

        if (EmploiDuTemps::salleConflict($salleId, $creneauId, $excludeId)) {
            $salle = Salle::find($salleId);
            return "Conflit : la salle {$salle->nom} est déjà occupée à ce créneau.";
        }

        if (EmploiDuTemps::filiereConflict($filiereId, $creneauId, $excludeId)) {
            $filiere = Filiere::find($filiereId);
            return "Conflit : la filière {$filiere->nom} a déjà un cours à ce créneau.";
        }

        return null;
    }
}