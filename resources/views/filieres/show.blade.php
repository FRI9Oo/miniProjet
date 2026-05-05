@extends('layouts.app')

@section('title', $filiere->nom)
@section('page-title', 'Filières')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('filieres.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">{{ $filiere->nom }}</h5>
    <span style="font-size:12px;background:#eeedfe;color:#534ab7;padding:3px 10px;
                 border-radius:20px;font-weight:600">
        {{ $filiere->code }}
    </span>
</div>

<div class="row g-3">
    {{-- Info card --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body p-4">
                <div style="font-size:13px">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Semestre</span>
                        <strong>S{{ $filiere->semestre }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Matières</span>
                        <strong>{{ $filiere->matieres->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Cours planifiés</span>
                        <strong>{{ $filiere->emplois->count() }}</strong>
                    </div>
                    @if($filiere->description)
                    <hr>
                    <p style="font-size:12px;color:#8892a4;line-height:1.6;margin:0">
                        {{ $filiere->description }}
                    </p>
                    @endif
                </div>
                <a href="{{ route('filieres.edit', $filiere) }}"
                   class="btn btn-sm w-100 mt-3" style="background:#eeedfe;color:#534ab7">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
            </div>
        </div>

        {{-- Matières list --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-book me-2"></i>Matières</div>
            <div class="card-body p-0">
                @forelse($filiere->matieres as $matiere)
                    <div class="px-4 py-2 border-bottom d-flex justify-content-between align-items-center"
                         style="font-size:13px">
                        <span>{{ $matiere->nom }}</span>
                        <span class="badge" style="background:#f0f2f5;color:#444;font-size:10px">
                            {{ strtoupper($matiere->type) }}
                        </span>
                    </div>
                @empty
                    <div class="px-4 py-3 text-muted" style="font-size:13px">
                        Aucune matière.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Emploi du temps --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-week me-2"></i>Emploi du temps</span>
                <a href="{{ route('emplois.export', $filiere) }}"
                   class="btn btn-sm" style="background:#f0f2f5;color:#444;font-size:12px">
                    <i class="bi bi-printer me-1"></i>Imprimer
                </a>
            </div>
            <div class="card-body p-0" style="overflow-x:auto">
                @if($filiere->emplois->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x" style="font-size:36px;opacity:.3"></i>
                        <p class="mt-2 mb-0">Aucun cours planifié pour cette filière.</p>
                    </div>
                @else
                    @php
                        $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi'];
                        $emploisParJour = $filiere->emplois->groupBy('creneau.jour');
                    @endphp
                    <table class="table mb-0" style="font-size:13px">
                        <thead>
                            <tr>
                                <th style="background:#1a1a2e;color:#fff;width:100px">Créneau</th>
                                @foreach($jours as $jour)
                                    <th style="background:#1a1a2e;color:#fff;text-align:center">
                                        {{ $jour }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filiere->emplois->pluck('creneau')->unique('id')->sortBy('heure_debut') as $creneau)
                            <tr>
                                <td style="background:#f7f8fa;font-size:11px;font-weight:600;
                                           color:#8892a4;text-align:center;vertical-align:middle">
                                    {{ $creneau->heure_debut }}<br>{{ $creneau->heure_fin }}
                                </td>
                                @foreach($jours as $jour)
                                    @php
                                        $cours = $filiere->emplois->first(function($e) use ($jour, $creneau) {
                                            return $e->creneau->jour === $jour && $e->creneau->id === $creneau->id;
                                        });
                                    @endphp
                                    <td style="vertical-align:middle;padding:6px">
                                        @if($cours)
                                            <div style="background:rgba(233,69,96,0.08);
                                                        border-left:3px solid #e94560;
                                                        border-radius:6px;padding:6px 8px">
                                                <div style="font-weight:600;font-size:12px;color:#1a1a2e">
                                                    {{ $cours->matiere->nom }}
                                                </div>
                                                <div style="font-size:10.5px;color:#8892a4;margin-top:2px">
                                                    {{ $cours->enseignant->nom_complet }}<br>
                                                    {{ $cours->salle->code }}
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
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