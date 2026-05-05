@extends('layouts.app')

@section('title', 'Modifier un cours')
@section('page-title', 'Emplois du temps')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('emplois.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">Modifier un cours</h5>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('emplois.update', $emploi) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        {{-- Filière — locked when editing --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Filière <span class="text-danger">*</span>
                            </label>
                            <input type="hidden" name="filiere_id" value="{{ $emploi->filiere_id }}">
                            <input type="text" class="form-control" 
                                   value="{{ $emploi->filiere->nom }} ({{ $emploi->filiere->code }})" 
                                   disabled
                                   style="background:#f7f8fa;color:#8892a4;">
                            <small style="color:#8892a4;font-size:11px;">Non modifiable</small>
                        </div>

                        {{-- Matière --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Matière <span class="text-danger">*</span>
                            </label>
                            <select name="matiere_id" id="matiere_id"
                                    class="form-select @error('matiere_id') is-invalid @enderror">
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}"
                                            data-filieres="{{ $matiere->filieres->pluck('id')->implode(',') }}"
                                        {{ old('matiere_id', $emploi->matiere_id) == $matiere->id ? 'selected' : '' }}>
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
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}"
                                        {{ old('enseignant_id', $emploi->enseignant_id) == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom_complet }}
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
                                @foreach($salles as $salle)
                                    <option value="{{ $salle->id }}"
                                        {{ old('salle_id', $emploi->salle_id) == $salle->id ? 'selected' : '' }}>
                                        {{ $salle->nom }} ({{ $salle->capacite }} places)
                                    </option>
                                @endforeach
                            </select>
                            @error('salle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Créneau --}}
                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Créneau <span class="text-danger">*</span>
                            </label>
                            <select name="creneau_id"
                                    class="form-select @error('creneau_id') is-invalid @enderror">
                                @php $currentJour = ''; @endphp
                                @foreach($creneaux as $creneau)
                                    @if($creneau->jour !== $currentJour)
                                        @if($currentJour !== '') </optgroup> @endif
                                        <optgroup label="{{ $creneau->jour }}">
                                        @php $currentJour = $creneau->jour; @endphp
                                    @endif
                                    <option value="{{ $creneau->id }}"
                                        {{ old('creneau_id', $emploi->creneau_id) == $creneau->id ? 'selected' : '' }}>
                                        {{ substr($creneau->heure_debut,0,5) }} – {{ substr($creneau->heure_fin,0,5) }}
                                    </option>
                                @endforeach
                                @if($currentJour !== '') </optgroup> @endif
                            </select>
                            @error('creneau_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Notes --}}
                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">Notes</label>
                            <textarea name="notes" rows="2"
                                      class="form-control">{{ old('notes', $emploi->notes) }}</textarea>
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
</div>

@endsection

@push('scripts')
<script>
// Filter matieres by the locked filiere (always show matching ones)
(function () {
    const filiereId = '{{ $emploi->filiere_id }}';
    const options = document.getElementById('matiere_id').querySelectorAll('option');
    options.forEach(opt => {
        if (!opt.value) return;
        const filieres = (opt.dataset.filieres || '').split(',');
        opt.style.display = filieres.includes(filiereId) ? '' : 'none';
    });
})();
</script>
@endpush