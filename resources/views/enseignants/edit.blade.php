@extends('layouts.app')

@section('title', 'Modifier un enseignant')
@section('page-title', 'Enseignants')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('enseignants.index') }}" class="btn btn-sm"
       style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
        Modifier — {{ $enseignant->nom_complet }}
    </h5>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('enseignants.update', $enseignant) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500" style="font-size:13px">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nom"
                                   value="{{ old('nom', $enseignant->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-500" style="font-size:13px">
                                Prénom <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="prenom"
                                   value="{{ old('prenom', $enseignant->prenom) }}"
                                   class="form-control @error('prenom') is-invalid @enderror">
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-500" style="font-size:13px">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $enseignant->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-500" style="font-size:13px">
                                Téléphone
                            </label>
                            <input type="text"
                                   name="telephone"
                                   value="{{ old('telephone', $enseignant->telephone) }}"
                                   class="form-control @error('telephone') is-invalid @enderror">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-500" style="font-size:13px">
                                Spécialité
                            </label>
                            <input type="text"
                                   name="specialite"
                                   value="{{ old('specialite', $enseignant->specialite) }}"
                                   class="form-control @error('specialite') is-invalid @enderror">
                            @error('specialite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('enseignants.index') }}"
                           class="btn" style="background:#f0f2f5;color:#444">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection