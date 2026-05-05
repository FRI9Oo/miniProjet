@extends('layouts.app')

@section('title', 'Salles')
@section('page-title', 'Salles')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">Liste des salles</h5>
        <p class="text-muted mb-0" style="font-size:13px">{{ $salles->total() }} salle(s) enregistrée(s)</p>
    </div>
    <a href="{{ route('salles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Ajouter
    </a>
</div>

{{-- Type filter cards --}}
<div class="row g-3 mb-4">
    @foreach(['cours' => ['#3b5bdb','bi-easel'], 'td' => ['#0f9b72','bi-people'], 'tp' => ['#f59e0b','bi-pc-display'], 'amphi' => ['#e94560','bi-building']] as $type => $meta)
    <div class="col-6 col-lg-3">
        <div class="card" style="border-left:4px solid {{ $meta[0] }}">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi {{ $meta[1] }}" style="font-size:22px;color:{{ $meta[0] }}"></i>
                    <div>
                        <div style="font-size:20px;font-weight:700;font-family:'Syne',sans-serif">
                            {{ $salles->getCollection()->where('type', $type)->count() }}
                        </div>
                        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#8892a4">
                            {{ strtoupper($type) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body p-0">
        @if($salles->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-building" style="font-size:48px;opacity:.3"></i>
                <p class="mt-3">Aucune salle enregistrée.</p>
                <a href="{{ route('salles.create') }}" class="btn btn-primary btn-sm">
                    Ajouter la première salle
                </a>
            </div>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Capacité</th>
                        <th>Disponibilité</th>
                        <th style="width:130px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salles as $salle)
                    @php
                        $typeColors = [
                            'cours' => ['#eef2ff','#3b5bdb'],
                            'td'    => ['#e6f9f3','#0f9b72'],
                            'tp'    => ['#fef9ec','#f59e0b'],
                            'amphi' => ['#fff0f2','#e94560'],
                        ];
                        $color = $typeColors[$salle->type] ?? ['#f0f2f5','#444'];
                    @endphp
                    <tr>
                        <td>
                            <span style="font-family:'Syne',sans-serif;font-weight:700;
                                         font-size:13px;color:#1a1a2e">
                                {{ $salle->code }}
                            </span>
                        </td>
                        <td style="font-weight:500">{{ $salle->nom }}</td>
                        <td>
                            <span class="badge"
                                  style="background:{{ $color[0] }};color:{{ $color[1] }};
                                         font-size:11px;font-weight:600;text-transform:uppercase;
                                         letter-spacing:.05em">
                                {{ $salle->type }}
                            </span>
                        </td>
                        <td style="font-size:13px">
                            <i class="bi bi-people me-1 text-muted"></i>{{ $salle->capacite }}
                        </td>
                        <td>
                            @if($salle->disponible)
                                <span class="badge" style="background:#e6f9f3;color:#0f9b72;font-size:11px">
                                    <i class="bi bi-check-circle me-1"></i>Disponible
                                </span>
                            @else
                                <span class="badge" style="background:#fff0f2;color:#e94560;font-size:11px">
                                    <i class="bi bi-x-circle me-1"></i>Indisponible
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('salles.show', $salle) }}"
                                   class="btn btn-sm" style="background:#f0f2f5;color:#444">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('salles.edit', $salle) }}"
                                   class="btn btn-sm" style="background:#eeedfe;color:#534ab7">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('salles.destroy', $salle) }}"
                                      onsubmit="return confirm('Supprimer cette salle ?')">
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
            @if($salles->hasPages())
                <div class="px-4 py-3 border-top">{{ $salles->links() }}</div>
            @endif
        @endif
    </div>
</div>

@endsection