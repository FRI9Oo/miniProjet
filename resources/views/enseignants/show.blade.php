@extends('layouts.app')

@section('title', $enseignant->nom_complet)
@section('page-title', 'Enseignants')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('enseignants.index') }}" class="btn btn-sm"
       style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
        {{ $enseignant->nom_complet }}
    </h5>
</div>

<div class="row g-3">
    {{-- Profile card --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body p-4 text-center">
                <div style="width:64px;height:64px;border-radius:50%;
                            background:#eeedfe;border:3px solid #e94560;
                            display:flex;align-items:center;justify-content:center;
                            font-size:24px;font-weight:700;color:#534ab7;margin:0 auto 16px">
                    {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}
                </div>
                <h6 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:4px">
                    {{ $enseignant->nom_complet }}
                </h6>
                @if($enseignant->specialite)
                    <span class="badge"
                          style="background:#f0f2f5;color:#444;font-size:11px;font-weight:500">
                        {{ $enseignant->specialite }}
                    </span>
                @endif

                <hr>

                <div class="text-start" style="font-size:13px">
                    <div class="mb-2">
                        <i class="bi bi-envelope me-2 text-muted"></i>
                        {{ $enseignant->email }}
                    </div>
                    @if($enseignant->telephone)
                    <div class="mb-2">
                        <i class="bi bi-telephone me-2 text-muted"></i>
                        {{ $enseignant->telephone }}
                    </div>
                    @endif
                    <div>
                        <i class="bi bi-calendar3 me-2 text-muted"></i>
                        {{ $enseignant->emplois->count() }} cours planifiés
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('enseignants.edit', $enseignant) }}"
                       class="btn btn-sm w-100"
                       style="background:#eeedfe;color:#534ab7">
                        <i class="bi bi-pencil me-1"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Schedule --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-week me-2"></i>Planning de {{ $enseignant->prenom }}
            </div>
            <div class="card-body p-0">
                @if($enseignant->emplois->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x" style="font-size:36px;opacity:.3"></i>
                        <p class="mt-2 mb-0">Aucun cours planifié.</p>
                    </div>
                @else
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Jour</th>
                                <th>Créneau</th>
                                <th>Matière</th>
                                <th>Salle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enseignant->emplois->sortBy('creneau.jour') as $emploi)
                            <tr>
                                <td style="font-weight:500">
                                    {{ $emploi->creneau->jour }}
                                </td>
                                <td style="font-size:13px">
                                    {{ $emploi->creneau->heure_debut }}
                                    — {{ $emploi->creneau->heure_fin }}
                                </td>
                                <td>
                                    <span class="badge"
                                          style="background:#eeedfe;color:#534ab7;font-weight:500">
                                        {{ $emploi->matiere->nom }}
                                    </span>
                                </td>
                                <td style="font-size:13px">
                                    {{ $emploi->salle->nom }}
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