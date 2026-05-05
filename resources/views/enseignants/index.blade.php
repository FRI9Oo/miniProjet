@extends('layouts.app')

@section('title', 'Enseignants')
@section('page-title', 'Enseignants')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">
            Liste des enseignants
        </h5>
        <p class="text-muted mb-0" style="font-size:13px">
            {{ $enseignants->total() }} enseignant(s) enregistré(s)
        </p>
    </div>
    <a href="{{ route('enseignants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Ajouter
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($enseignants->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-badge" style="font-size:48px;opacity:.3"></i>
                <p class="mt-3">Aucun enseignant enregistré.</p>
                <a href="{{ route('enseignants.create') }}" class="btn btn-primary btn-sm">
                    Ajouter le premier enseignant
                </a>
            </div>
        @else
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Spécialité</th>
                        <th style="width:130px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enseignants as $enseignant)
                    <tr>
                        <td class="text-muted" style="font-size:12px">{{ $enseignant->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:50%;background:#eeedfe;
                                            display:flex;align-items:center;justify-content:center;
                                            font-size:12px;font-weight:600;color:#534ab7;flex-shrink:0">
                                    {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:500;font-size:14px">
                                        {{ $enseignant->nom_complet }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px">{{ $enseignant->email }}</td>
                        <td style="font-size:13px">{{ $enseignant->telephone ?? '—' }}</td>
                        <td>
                            @if($enseignant->specialite)
                                <span class="badge"
                                      style="background:#f0f2f5;color:#444;font-weight:500;font-size:11px">
                                    {{ $enseignant->specialite }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('enseignants.show', $enseignant) }}"
                                   class="btn btn-sm"
                                   style="background:#f0f2f5;color:#444"
                                   title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('enseignants.edit', $enseignant) }}"
                                   class="btn btn-sm"
                                   style="background:#eeedfe;color:#534ab7"
                                   title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('enseignants.destroy', $enseignant) }}"
                                      onsubmit="return confirm('Supprimer cet enseignant ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm"
                                            style="background:#fff0f2;color:#e94560"
                                            title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($enseignants->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $enseignants->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection