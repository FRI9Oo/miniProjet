@extends('layouts.app')

@section('title', 'Mon planning')
@section('page-title', 'Mon planning')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">
            Mon planning — {{ $enseignant->nom }} {{ $enseignant->prenom }}
        </h5>
        <p class="text-muted mb-0" style="font-size:13px">
            {{ $enseignant->specialite ?? 'Enseignant' }}
        </p>
    </div>
    <a href="{{ route('enseignants.export') }}" 
       class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-printer me-1"></i>Imprimer
    </a>
</div>

@if(collect($grid)->flatten()->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-calendar-x" style="font-size:48px;opacity:.3"></i>
            <p class="mt-3 mb-0">Aucun cours planifié pour le moment.</p>
        </div>
    </div>
@else
    <div class="row g-3 mb-4">
        @foreach($jours as $jour)
            @php $count = isset($grid[$jour]) ? count($grid[$jour]) : 0; @endphp
            @if($count > 0)
            <div class="col-auto">
                <div class="card px-4 py-2 text-center">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:#e94560">{{ $count }}</div>
                    <div style="font-size:11px;color:#8892a4">{{ $jour }}</div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

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
                        <td style="text-align:center;vertical-align:middle;font-size:11px;font-weight:600;color:#8892a4;background:#f7f8fa">
                            {{ substr($creneau->heure_debut,0,5) }}<br>
                            <span style="color:#c0c8d4;font-weight:400">{{ substr($creneau->heure_fin,0,5) }}</span>
                        </td>
                        @foreach($jours as $jour)
                            @php $cours = $grid[$jour][$creneau->heure_debut] ?? null; @endphp
                            <td style="vertical-align:top;padding:6px;min-width:130px;height:80px">
                                @if($cours)
                                    <div class="cours-cell" style="background:#eeedfe;border-left:3px solid #534ab7;border-radius:6px;padding:8px;height:100%">
                                        <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:13px;color:#1a1a2e">{{ $cours->matiere->nom }}</div>
                                        <div style="font-size:11px;color:#8892a4;margin-top:4px">
                                            <i class="bi bi-diagram-3 me-1"></i>{{ $cours->filiere->code }}<br>
                                            <i class="bi bi-building me-1"></i>{{ $cours->salle->code }}
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