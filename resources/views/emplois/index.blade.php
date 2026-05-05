@extends('layouts.app')

@section('title', 'Emplois du temps')
@section('page-title', 'Emplois du temps')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">Gestion des cours</h5>
        <p class="text-muted mb-0" style="font-size:13px">{{ $emplois->total() }} cours planifié(s)</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('emplois.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Ajouter un cours
        </a>
    </div>
</div>

{{-- Quick access grid by filiere --}}
<div class="row g-3 mb-4">
    @foreach($filieres as $filiere)
    <div class="col-md-4 col-lg-3">
        <a href="{{ route('emplois.filiere', $filiere) }}"
           class="card text-decoration-none h-100"
           style="transition:box-shadow .2s">
            <div class="card-body py-3 px-4 d-flex align-items-center gap-3">
                <div style="width:40px;height:40px;border-radius:10px;background:#eeedfe;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="bi bi-calendar-week" style="color:#534ab7;font-size:18px"></i>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#1a1a2e">
                        {{ $filiere->code }}
                    </div>
                    <div style="font-size:11px;color:#8892a4">
                        Voir la grille
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

{{-- Full list table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul me-2"></i>Tous les cours</span>
    </div>
    <div class="card-body p-0">
        @if($emplois->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-plus" style="font-size:48px;opacity:.3"></i>
                <p class="mt-3">Aucun cours planifié.</p>
                <a href="{{ route('emplois.create') }}" class="btn btn-primary btn-sm">
                    Ajouter le premier cours
                </a>
            </div>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Filière</th>
                        <th>Matière</th>
                        <th>Enseignant</th>
                        <th>Salle</th>
                        <th>Créneau</th>
                        <th style="width:110px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emplois as $emploi)
                    <tr>
                        <td>
                            <span class="badge"
                                  style="background:#eeedfe;color:#534ab7;font-weight:600;font-size:11px">
                                {{ $emploi->filiere->code }}
                            </span>
                        </td>
                        <td style="font-weight:500;font-size:13px">{{ $emploi->matiere->nom }}</td>
                        <td style="font-size:13px">{{ $emploi->enseignant->nom_complet }}</td>
                        <td>
                            <span class="badge"
                                  style="background:#f0f2f5;color:#444;font-size:11px">
                                {{ $emploi->salle->code }}
                            </span>
                        </td>
                        <td style="font-size:13px">
                            <strong>{{ $emploi->creneau->jour }}</strong>
                            <span class="text-muted ms-1">
                                {{ substr($emploi->creneau->heure_debut,0,5) }}–{{ substr($emploi->creneau->heure_fin,0,5) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('emplois.edit', $emploi) }}"
                                   class="btn btn-sm" style="background:#eeedfe;color:#534ab7">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('emplois.destroy', $emploi) }}"
                                      onsubmit="return confirm('Supprimer ce cours ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                            style="background:#fff0f2;color:#e94560">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($emplois->hasPages())
                <div class="px-4 py-3 border-top">{{ $emplois->links() }}</div>
            @endif
        @endif
    </div>
</div>

@endsection