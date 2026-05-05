@extends('layouts.app')

@section('title', 'Mon emploi du temps')
@section('page-title', 'Mon emploi du temps')

@section('content')

<div class="mb-4">
    <h5 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:700">
        Choisir une filière
    </h5>
    <p class="text-muted mb-0" style="font-size:13px">
        Sélectionnez votre filière pour consulter l'emploi du temps.
    </p>
</div>

<div class="row g-3">
    @forelse($filieres as $filiere)
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('etudiant.emploi.show', $filiere) }}"
           class="card h-100 text-decoration-none"
           style="transition:transform .15s,box-shadow .15s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'"
           onmouseout="this.style.transform='';this.style.boxShadow=''">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div style="width:46px;height:46px;border-radius:12px;
                                background:linear-gradient(135deg,#e94560,#c73652);
                                display:flex;align-items:center;justify-content:center">
                        <i class="bi bi-calendar-week" style="font-size:20px;color:#fff"></i>
                    </div>
                    <span style="font-size:11px;background:#eeedfe;color:#534ab7;
                                 padding:3px 8px;border-radius:20px;font-weight:600">
                        S{{ $filiere->semestre }}
                    </span>
                </div>
                <div style="font-family:'Syne',sans-serif;font-weight:800;
                             font-size:20px;color:#1a1a2e;margin-bottom:2px">
                    {{ $filiere->code }}
                </div>
                <div style="font-size:13px;color:#8892a4;margin-bottom:14px">
                    {{ $filiere->nom }}
                </div>
                <div style="font-size:12px;color:#8892a4">
                    <i class="bi bi-calendar-check me-1"></i>
                    {{ $filiere->emplois_count }} cours planifiés
                </div>
            </div>
        </a>
    </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-calendar-x" style="font-size:48px;opacity:.3"></i>
                    <p class="mt-3">Aucune filière disponible pour le moment.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

@endsection