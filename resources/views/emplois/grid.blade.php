@extends('layouts.app')

@section('title', 'Grille — ' . $filiere->nom)
@section('page-title', 'Emplois du temps')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('emplois.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
                {{ $filiere->nom }}
                <span style="font-size:13px;background:#eeedfe;color:#534ab7;
                             padding:3px 10px;border-radius:20px;font-weight:600;margin-left:6px">
                    {{ $filiere->code }}
                </span>
            </h5>
        </div>
    </div>
    <div class="d-flex gap-2">
        {{-- Filiere switcher --}}
        <select onchange="window.location=this.value"
                class="form-select form-select-sm" style="width:160px">
            @foreach($filieres as $f)
                <option value="{{ route('emplois.filiere', $f) }}"
                    {{ $f->id === $filiere->id ? 'selected' : '' }}>
                    {{ $f->code }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('emplois.export', $filiere) }}"
           target="_blank"
           class="btn btn-sm" style="background:#f0f2f5;color:#444">
            <i class="bi bi-printer me-1"></i> Imprimer
        </a>
        <a href="{{ route('emplois.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Ajouter
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0" style="overflow-x:auto">
        @if(empty(array_filter($grid)))
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-x" style="font-size:48px;opacity:.3"></i>
                <p class="mt-3">Aucun cours planifié pour cette filière.</p>
                <a href="{{ route('emplois.create') }}" class="btn btn-primary btn-sm">
                    Planifier le premier cours
                </a>
            </div>
        @else
            <table class="timetable-grid">
                <thead>
                    <tr>
                        <th style="width:90px">Horaire</th>
                        @foreach($jours as $jour)
                            <th>{{ $jour }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($creneaux as $creneau)
                    <tr>
                        <td style="text-align:center;vertical-align:middle;
                                   font-size:11px;font-weight:600;color:#8892a4;
                                   background:#f7f8fa">
                            {{ substr($creneau->heure_debut,0,5) }}<br>
                            <span style="color:#c0c8d4">{{ substr($creneau->heure_fin,0,5) }}</span>
                        </td>
                        @foreach($jours as $jour)
                            @php
                                $cours = $grid[$jour][$creneau->heure_debut] ?? null;
                            @endphp
                            <td style="vertical-align:top;padding:6px;min-width:130px;height:80px">
                                @if($cours)
                                    <div class="cours-cell">
                                        <div class="matiere-name">{{ $cours->matiere->nom }}</div>
                                        <div class="cours-meta mt-1">
                                            <i class="bi bi-person me-1"></i>{{ $cours->enseignant->nom_complet }}<br>
                                            <i class="bi bi-building me-1"></i>{{ $cours->salle->code }}
                                        </div>
                                        <div class="d-flex gap-2 mt-2">
                                            <a href="{{ route('emplois.edit', $cours) }}"
                                            class="btn btn-sm"
                                            style="background:rgba(83,74,183,0.15);color:#534ab7;padding:3px 10px;font-size:11px;border-radius:6px;font-weight:600;text-decoration:none;">
                                                <i class="bi bi-pencil me-1"></i>Modifier
                                            </a>
                                            <form method="POST"
                                                action="{{ route('emplois.destroy', $cours) }}"
                                                onsubmit="return confirm('Supprimer ce cours ?')"
                                                style="display:inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        style="background:rgba(233,69,96,0.12);color:#e94560;padding:3px 10px;font-size:11px;border-radius:6px;font-weight:600;border:none;cursor:pointer;">
                                                    <i class="bi bi-trash me-1"></i>Supprimer
                                                </button>
                                            </form>
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

@endsection