@extends('layouts.app')

@section('title', 'Modifier une matière')
@section('page-title', 'Matières')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('matieres.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
        Modifier — {{ $matiere->nom }}
    </h5>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('matieres.update', $matiere) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom"
                                   value="{{ old('nom', $matiere->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="code"
                                   value="{{ old('code', $matiere->code) }}"
                                   class="form-control @error('code') is-invalid @enderror">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Filières <span class="text-danger">*</span>
                            </label>
                            <div style="max-height:180px;overflow-y:auto;border:1px solid #dde2ea;border-radius:8px;padding:12px;">
                                @php
                                    $selectedFilieres = old('filieres', $matiere->filieres->pluck('id')->toArray());
                                @endphp
                                @foreach($filieres as $filiere)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="filieres[]" value="{{ $filiere->id }}"
                                               id="filiere_{{ $filiere->id }}"
                                               {{ in_array($filiere->id, $selectedFilieres) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="filiere_{{ $filiere->id }}" style="font-size:13px">
                                            {{ $filiere->nom }} ({{ $filiere->code }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('filieres')<div class="text-danger" style="font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                        </div>

                        {{-- Hidden field for backward compatibility --}}
                        <input type="hidden" name="filiere_id" value="{{ old('filiere_id', $matiere->filiere_id ?? $matiere->filieres->first()?->id) }}">

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Type <span class="text-danger">*</span>
                            </label>
                            <select name="type"
                                    class="form-select @error('type') is-invalid @enderror">
                                @foreach(['cours','td','tp'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('type', $matiere->type) == $type ? 'selected' : '' }}>
                                        {{ strtoupper($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Volume horaire (h) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="volume_horaire"
                                   value="{{ old('volume_horaire', $matiere->volume_horaire) }}"
                                   min="1" max="500" step="0.5"
                                   class="form-control @error('volume_horaire') is-invalid @enderror">
                            @error('volume_horaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('matieres.index') }}"
                           class="btn" style="background:#f0f2f5;color:#444">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection