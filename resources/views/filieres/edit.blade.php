@extends('layouts.app')

@section('title', 'Modifier une filière')
@section('page-title', 'Filières')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('filieres.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
        Modifier — {{ $filiere->nom }}
    </h5>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('filieres.update', $filiere) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom"
                                   value="{{ old('nom', $filiere->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="code"
                                   value="{{ old('code', $filiere->code) }}"
                                   class="form-control @error('code') is-invalid @enderror">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Semestre <span class="text-danger">*</span>
                            </label>
                            <select name="semestre"
                                    class="form-select @error('semestre') is-invalid @enderror">
                                @for($s = 1; $s <= 6; $s++)
                                    <option value="{{ $s }}"
                                        {{ old('semestre', $filiere->semestre) == $s ? 'selected' : '' }}>
                                        Semestre {{ $s }}
                                    </option>
                                @endfor
                            </select>
                            @error('semestre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Description
                            </label>
                            <textarea name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $filiere->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('filieres.index') }}"
                           class="btn" style="background:#f0f2f5;color:#444">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection