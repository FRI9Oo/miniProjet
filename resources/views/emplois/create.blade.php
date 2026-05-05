@extends('layouts.app')

@section('title', 'Ajouter un cours')
@section('page-title', 'Emplois du temps')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('emplois.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">Ajouter un cours</h5>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('emplois.store') }}" id="emploiForm">
                    @csrf

                    <div class="row g-3">

                        {{-- Filiere --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Filière <span class="text-danger">*</span>
                            </label>
                            <select name="filiere_id" id="filiere_id"
                                    class="form-select @error('filiere_id') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}"
                                        {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                        {{ $filiere->nom }} ({{ $filiere->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('filiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Matiere — filtered by filiere via JS --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Matière <span class="text-danger">*</span>
                            </label>
                            <select name="matiere_id" id="matiere_id"
                                    class="form-select @error('matiere_id') is-invalid @enderror">
                                <option value="">-- Choisir une filière d'abord --</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}"
                                            data-filieres="{{ $matiere->filieres->pluck('id')->implode(',') }}"
                                            {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Enseignant --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Enseignant <span class="text-danger">*</span>
                            </label>
                            <select name="enseignant_id"
                                    class="form-select @error('enseignant_id') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}"
                                        {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom_complet }}
                                        @if($enseignant->specialite)
                                            ({{ $enseignant->specialite }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('enseignant_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Salle --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Salle <span class="text-danger">*</span>
                            </label>
                            <select name="salle_id"
                                    class="form-select @error('salle_id') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                @foreach($salles as $salle)
                                    <option value="{{ $salle->id }}"
                                        {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                        {{ $salle->nom }} — {{ strtoupper($salle->type) }}
                                        ({{ $salle->capacite }} places)
                                    </option>
                                @endforeach
                            </select>
                            @error('salle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Creneau --}}
                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Créneau <span class="text-danger">*</span>
                            </label>
                            <select name="creneau_id"
                                    class="form-select @error('creneau_id') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                @php $currentJour = ''; @endphp
                                @foreach($creneaux as $creneau)
                                    @if($creneau->jour !== $currentJour)
                                        @if($currentJour !== '') </optgroup> @endif
                                        <optgroup label="{{ $creneau->jour }}">
                                        @php $currentJour = $creneau->jour; @endphp
                                    @endif
                                    <option value="{{ $creneau->id }}"
                                        {{ old('creneau_id') == $creneau->id ? 'selected' : '' }}>
                                        {{ substr($creneau->heure_debut,0,5) }} – {{ substr($creneau->heure_fin,0,5) }}
                                        @if($creneau->libelle) — {{ $creneau->libelle }} @endif
                                    </option>
                                @endforeach
                                @if($currentJour !== '') </optgroup> @endif
                            </select>
                            @error('creneau_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Notes --}}
                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Notes
                            </label>
                            <textarea name="notes" rows="2"
                                      class="form-control"
                                      placeholder="Remarques éventuelles...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('emplois.index') }}"
                           class="btn" style="background:#f0f2f5;color:#444">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Conflict info card --}}
    <div class="col-lg-5">
        <div class="card" style="border-left:4px solid #e94560">
            <div class="card-body p-4">
                <div style="font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:10px">
                    <i class="bi bi-shield-check me-2" style="color:#e94560"></i>
                    Détection automatique des conflits
                </div>
                <div style="font-size:12px;color:#8892a4;line-height:1.8">
                    Le système vérifie automatiquement :<br>
                    <span style="color:#1a1a2e">✓</span> L'enseignant n'est pas déjà assigné à ce créneau<br>
                    <span style="color:#1a1a2e">✓</span> La salle n'est pas déjà occupée<br>
                    <span style="color:#1a1a2e">✓</span> La filière n'a pas déjà un cours
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter matieres by selected filiere (supports many-to-many)
document.getElementById('filiere_id').addEventListener('change', function () {
    const filiereId = this.value;
    const matiereSelect = document.getElementById('matiere_id');
    const options = matiereSelect.querySelectorAll('option');
    let visibleCount = 0;

    options.forEach(opt => {
        if (!opt.value) {
            opt.textContent = '-- Choisir --';
            opt.style.display = '';
            return;
        }
        // Check data-filieres (comma-separated list of filiere IDs)
        const filieres = (opt.dataset.filieres || '').split(',');
        if (!filiereId || filieres.includes(filiereId)) {
            opt.style.display = '';
            visibleCount++;
        } else {
            opt.style.display = 'none';
        }
    });

    if (visibleCount === 0 && filiereId) {
        options.forEach(opt => { if (opt.value) opt.style.display = ''; });
        matiereSelect.querySelector('option[value=""]').textContent = '-- Aucune matière pour cette filière (toutes affichées) --';
    } else if (!filiereId) {
        matiereSelect.querySelector('option[value=""]').textContent = '-- Choisir une filière d\'abord --';
    }

    matiereSelect.value = '{{ old('matiere_id') }}';
});

document.getElementById('filiere_id').dispatchEvent(new Event('change'));
</script>
@endpush