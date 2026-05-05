@extends('layouts.app')

@section('title', 'Emploi du temps — ' . $filiere->nom)
@section('page-title', 'Mon emploi du temps')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-2">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('etudiant.emploi') }}" class="btn btn-sm"
               style="background:#f0f2f5;color:#444">
                <i class="bi bi-arrow-left"></i>
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-sm"
               style="background:#f0f2f5;color:#444">
                <i class="bi bi-arrow-left"></i>
            </a>
        @endif
        <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
            {{ $filiere->nom }}
            <span style="font-size:12px;background:#eeedfe;color:#534ab7;
                         padding:3px 10px;border-radius:20px;font-weight:600;margin-left:6px">
                {{ $filiere->code }}
            </span>
        </h5>
    </div>

    @if(auth()->user()->isAdmin())
        <a href="{{ route('emplois.export', $filiere) }}" 
           class="btn btn-sm" style="background:#f0f2f5;color:#444">
            <i class="bi bi-printer me-1"></i>Imprimer
        </a>
    @else
        <a href="{{ route('etudiant.export') }}" 
           class="btn btn-sm" style="background:#f0f2f5;color:#444">
            <i class="bi bi-printer me-1"></i>Imprimer
        </a>
    @endif
</div>

@if(collect($grid)->flatten(1)->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-calendar-x" style="font-size:48px;opacity:.3"></i>
            <p class="mt-3 mb-0">Aucun cours planifié pour cette filière.</p>
        </div>
    </div>
@else
    {{-- Stats row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#e94560">
                    {{ collect($grid)->map(fn($j) => count($j))->sum() }}
                </div>
                <div style="font-size:11px;color:#8892a4;text-transform:uppercase;letter-spacing:.06em">
                    Cours / semaine
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#3b5bdb">
                    {{ collect($grid)->filter()->count() }}
                </div>
                <div style="font-size:11px;color:#8892a4;text-transform:uppercase;letter-spacing:.06em">
                    Jours actifs
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#0f9b72">
                    {{ $creneaux->count() }}
                </div>
                <div style="font-size:11px;color:#8892a4;text-transform:uppercase;letter-spacing:.06em">
                    Créneaux
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#f59e0b">
                    S{{ $filiere->semestre }}
                </div>
                <div style="font-size:11px;color:#8892a4;text-transform:uppercase;letter-spacing:.06em">
                    Semestre
                </div>
            </div>
        </div>
    </div>

    {{-- Timetable grid --}}
    <div class="card">
        <div class="card-body p-0" style="overflow-x:auto">
            <table class="timetable-grid">
                <thead>
                    <tr>
                        <th style="width:80px">Horaire</th>
                        @foreach($jours as $jour)
                            <th>{{ $jour }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($creneaux as $creneau)
                    <tr>
                        <td style="text-align:center;vertical-align:middle;font-size:11px;
                                   font-weight:600;color:#8892a4;background:#f7f8fa">
                            {{ substr($creneau->heure_debut,0,5) }}<br>
                            <span style="color:#c0c8d4;font-weight:400">
                                {{ substr($creneau->heure_fin,0,5) }}
                            </span>
                        </td>
                        @foreach($jours as $jour)
                            @php $cours = $grid[$jour][$creneau->heure_debut] ?? null; @endphp
                            <td style="vertical-align:top;padding:6px;min-width:130px;height:80px">
                                @if($cours)
                                    <div class="cours-cell">
                                        <div class="matiere-name">
                                            {{ $cours->matiere->nom }}
                                        </div>
                                        <div class="cours-meta mt-1">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $cours->enseignant->nom_complet }}<br>
                                            <i class="bi bi-building me-1"></i>
                                            {{ $cours->salle->nom }}
                                        </div>
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection