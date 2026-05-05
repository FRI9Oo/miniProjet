@extends('layouts.app')

@section('title', $matiere->nom)
@section('page-title', 'Matières')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('matieres.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">{{ $matiere->nom }}</h5>
    <span style="font-size:11px;background:#eeedfe;color:#534ab7;
                 padding:3px 10px;border-radius:20px;font-weight:600">
        {{ $matiere->code }}
    </span>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <div style="font-size:13px">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Filière</span>
                        <strong>{{ $matiere->filiere->nom }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Type</span>
                        <span class="badge"
                              style="background:#eeedfe;color:#534ab7;font-size:11px">
                            {{ strtoupper($matiere->type) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Volume horaire</span>
                        <strong>{{ $matiere->volume_horaire }}h</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Cours planifiés</span>
                        <strong>{{ $matiere->emplois->count() }}</strong>
                    </div>
                </div>
                <a href="{{ route('matieres.edit', $matiere) }}"
                   class="btn btn-sm w-100 mt-3" style="background:#eeedfe;color:#534ab7">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-week me-2"></i>Cours planifiés pour cette matière
            </div>
            <div class="card-body p-0">
                @if($matiere->emplois->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x" style="font-size:36px;opacity:.3"></i>
                        <p class="mt-2 mb-0">Aucun cours planifié pour cette matière.</p>
                    </div>
                @else
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Jour</th>
                                <th>Créneau</th>
                                <th>Enseignant</th>
                                <th>Salle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matiere->emplois as $emploi)
                            <tr>
                                <td style="font-weight:500">{{ $emploi->creneau->jour }}</td>
                                <td style="font-size:13px">
                                    {{ $emploi->creneau->heure_debut }} — {{ $emploi->creneau->heure_fin }}
                                </td>
                                <td style="font-size:13px">{{ $emploi->enseignant->nom_complet }}</td>
                                <td>
                                    <span class="badge"
                                          style="background:#f0f2f5;color:#444;font-size:11px">
                                        {{ $emploi->salle->nom }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection