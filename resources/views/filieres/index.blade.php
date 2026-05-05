@extends('layouts.app')

@section('title', 'Filières')
@section('page-title', 'Filières')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">Liste des filières</h5>
        <p class="text-muted mb-0" style="font-size:13px">{{ $filieres->total() }} filière(s) enregistrée(s)</p>
    </div>
    <a href="{{ route('filieres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Ajouter
    </a>
</div>

<div class="row g-3">
    @forelse($filieres as $filiere)
    <div class="col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#1a1a2e">
                            {{ $filiere->code }}
                        </span>
                        <div style="font-size:13px;color:#8892a4;margin-top:2px">
                            Semestre {{ $filiere->semestre }}
                        </div>
                    </div>
                    <div style="width:42px;height:42px;border-radius:10px;background:#eeedfe;
                                display:flex;align-items:center;justify-content:center">
                        <i class="bi bi-diagram-3" style="font-size:20px;color:#534ab7"></i>
                    </div>
                </div>

                <h6 style="font-weight:600;margin-bottom:6px">{{ $filiere->nom }}</h6>

                @if($filiere->description)
                    <p style="font-size:12px;color:#8892a4;margin-bottom:14px;line-height:1.6">
                        {{ Str::limit($filiere->description, 80) }}
                    </p>
                @endif

                <div class="d-flex gap-3 mb-4" style="font-size:12px">
                    <div>
                        <span style="font-weight:700;font-size:18px;color:#1a1a2e">
                            {{ $filiere->matieres_count }}
                        </span>
                        <span class="text-muted ms-1">matières</span>
                    </div>
                    <div>
                        <span style="font-weight:700;font-size:18px;color:#1a1a2e">
                            {{ $filiere->emplois_count }}
                        </span>
                        <span class="text-muted ms-1">cours</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('filieres.show', $filiere) }}"
                       class="btn btn-sm flex-fill" style="background:#f0f2f5;color:#444">
                        <i class="bi bi-eye me-1"></i>Voir
                    </a>
                    <a href="{{ route('filieres.edit', $filiere) }}"
                       class="btn btn-sm flex-fill" style="background:#eeedfe;color:#534ab7">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                    <form method="POST" action="{{ route('filieres.destroy', $filiere) }}"
                          onsubmit="return confirm('Supprimer cette filière ? Toutes les matières et cours associés seront supprimés.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm"
                                style="background:#fff0f2;color:#e94560">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-diagram-3" style="font-size:48px;opacity:.3"></i>
                    <p class="mt-3">Aucune filière enregistrée.</p>
                    <a href="{{ route('filieres.create') }}" class="btn btn-primary btn-sm">
                        Ajouter la première filière
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($filieres->hasPages())
    <div class="mt-3">{{ $filieres->links() }}</div>
@endif

@endsection 