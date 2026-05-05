@extends('layouts.app')

@section('title', 'Créneaux')
@section('page-title', 'Créneaux horaires')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">Créneaux horaires</h5>
        <p class="text-muted mb-0" style="font-size:13px">{{ $creneaux->count() }} créneau(x) défini(s)</p>
    </div>
    <a href="{{ route('creneaux.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Ajouter
    </a>
</div>

@php
    $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    $parJour = $creneaux->groupBy('jour');
@endphp

@foreach($jours as $jour)
    @if($parJour->has($jour))
    <div class="mb-4">
        <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;
                    color:#1a1a2e;margin-bottom:10px;display:flex;align-items:center;gap:8px">
            <span style="width:8px;height:8px;border-radius:50%;background:#e94560;display:inline-block"></span>
            {{ $jour }}
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0" style="width:100%;table-layout:fixed;">
                    <thead>
                        <tr>
                            <th style="width:15%">Début</th>
                            <th style="width:15%">Fin</th>
                            <th style="width:22%">Libellé</th>
                            <th style="width:28%">Cours planifiés</th>
                            <th style="width:10%">Actions</th>
                        </tr>
                    </thead>   
                    <tbody>
                        @foreach($parJour[$jour] as $creneau)
                        <tr>
                            <td style="vertical-align:middle">
                                <span style="font-family:'Syne',sans-serif;font-weight:700;
                                             font-size:15px;color:#1a1a2e">
                                    {{ substr($creneau->heure_debut, 0, 5) }}
                                </span>
                            </td>
                            <td style="font-size:13px;color:#8892a4;vertical-align:middle">
                                {{ substr($creneau->heure_fin, 0, 5) }}
                            </td>
                            <td style="font-size:13px;vertical-align:middle">
                                {{ $creneau->libelle ?? '—' }}
                            </td>
                            <td style="vertical-align:middle">
                                <span class="badge"
                                      style="background:#eeedfe;color:#534ab7;font-size:11px">
                                    {{ $creneau->emplois->count() }} cours
                                </span>
                            </td>
                            <td style="vertical-align:middle">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('creneaux.edit', ['creneau' => $creneau->id]) }}"
                                       class="btn btn-sm" style="background:#eeedfe;color:#534ab7">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST"
                                        action="{{ route('creneaux.destroy', ['creneau' => $creneau->id]) }}"
                                        onsubmit="return confirm('Supprimer ce créneau ? Les cours associés seront supprimés.')"
                                        style="display:inline">
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
            </div>
        </div>
    </div>
    @endif
@endforeach

@if($creneaux->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-clock" style="font-size:48px;opacity:.3"></i>
            <p class="mt-3">Aucun créneau défini.</p>
            <a href="{{ route('creneaux.create') }}" class="btn btn-primary btn-sm">
                Ajouter le premier créneau
            </a>
        </div>
    </div>
@endif

@endsection