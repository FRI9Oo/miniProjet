@extends('layouts.app')

@section('title', 'Matières')
@section('page-title', 'Matières')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">Liste des matières</h5>
        <p class="text-muted mb-0" style="font-size:13px">{{ $matieres->total() }} matière(s) enregistrée(s)</p>
    </div>
    <a href="{{ route('matieres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Ajouter
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($matieres->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-book" style="font-size:48px;opacity:.3"></i>
                <p class="mt-3">Aucune matière enregistrée.</p>
                <a href="{{ route('matieres.create') }}" class="btn btn-primary btn-sm">
                    Ajouter la première matière
                </a>
            </div>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Filière</th>
                        <th>Type</th>
                        <th>Volume horaire</th>
                        <th style="width:130px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matieres as $matiere)
                    @php
                        $typeColors = [
                            'cours' => ['#eef2ff','#3b5bdb'],
                            'td'    => ['#e6f9f3','#0f9b72'],
                            'tp'    => ['#fef9ec','#f59e0b'],
                        ];
                        $color = $typeColors[$matiere->type] ?? ['#f0f2f5','#444'];
                    @endphp
                    <tr>
                        <td>
                            <span style="font-family:'Syne',sans-serif;font-weight:700;
                                         font-size:12px;color:#1a1a2e">
                                {{ $matiere->code }}
                            </span>
                        </td>
                        <td style="font-weight:500">{{ $matiere->nom }}</td>
                        <td>
                            <span class="badge"
                                  style="background:#eeedfe;color:#534ab7;font-size:11px;font-weight:500">
                                {{ $matiere->filiere->code ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge"
                                  style="background:{{ $color[0] }};color:{{ $color[1] }};
                                         font-size:11px;font-weight:600;text-transform:uppercase">
                                {{ $matiere->type }}
                            </span>
                        </td>
                        <td style="font-size:13px">
                            <i class="bi bi-clock me-1 text-muted"></i>{{ $matiere->volume_horaire }}h
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('matieres.show', $matiere) }}"
                                   class="btn btn-sm" style="background:#f0f2f5;color:#444">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('matieres.edit', $matiere) }}"
                                   class="btn btn-sm" style="background:#eeedfe;color:#534ab7">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('matieres.destroy', $matiere) }}"
                                      onsubmit="return confirm('Supprimer cette matière ?')">
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
            @if($matieres->hasPages())
                <div class="px-4 py-3 border-top">{{ $matieres->links() }}</div>
            @endif
        @endif
    </div>
</div>

@endsection