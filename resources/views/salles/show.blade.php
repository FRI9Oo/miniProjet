@extends('layouts.app')

@section('title', $salle->nom)
@section('page-title', 'Salles')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('salles.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">{{ $salle->nom }}</h5>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-3">
                    <div style="width:60px;height:60px;border-radius:14px;background:#eeedfe;
                                display:flex;align-items:center;justify-content:center;
                                font-size:26px;margin:0 auto 12px">
                        <i class="bi bi-building" style="color:#534ab7"></i>
                    </div>
                    <h6 style="font-family:'Syne',sans-serif;font-weight:700">{{ $salle->nom }}</h6>
                    <span class="badge" style="background:#eeedfe;color:#534ab7;font-size:12px">
                        {{ strtoupper($salle->type) }}
                    </span>
                </div>
                <hr>
                <div style="font-size:13px">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Code</span>
                        <strong>{{ $salle->code }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Capacité</span>
                        <strong>{{ $salle->capacite }} places</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Cours planifiés</span>
                        <strong>{{ $salle->emplois->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Statut</span>
                        @if($salle->disponible)
                            <span style="color:#0f9b72;font-weight:500;font-size:12px">
                                <i class="bi bi-check-circle me-1"></i>Disponible
                            </span>
                        @else
                            <span style="color:#e94560;font-weight:500;font-size:12px">
                                <i class="bi bi-x-circle me-1"></i>Indisponible
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('salles.edit', $salle) }}"
                   class="btn btn-sm w-100 mt-3" style="background:#eeedfe;color:#534ab7">
                    <i class="bi bi-pencil me-1"></i> Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-week me-2"></i>Cours dans cette salle
            </div>
            <div class="card-body p-0">
                @if($salle->emplois->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x" style="font-size:36px;opacity:.3"></i>
                        <p class="mt-2 mb-0">Aucun cours planifié dans cette salle.</p>
                    </div>
                @else
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Jour</th>
                                <th>Créneau</th>
                                <th>Matière</th>
                                <th>Enseignant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salle->emplois as $emploi)
                            <tr>
                                <td style="font-weight:500">{{ $emploi->creneau->jour }}</td>
                                <td style="font-size:13px">
                                    {{ $emploi->creneau->heure_debut }} — {{ $emploi->creneau->heure_fin }}
                                </td>
                                <td>
                                    <span class="badge" style="background:#eeedfe;color:#534ab7;font-weight:500">
                                        {{ $emploi->matiere->nom }}
                                    </span>
                                </td>
                                <td style="font-size:13px">{{ $emploi->enseignant->nom_complet }}</td>
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