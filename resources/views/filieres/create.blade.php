@extends('layouts.app')

@section('title', 'Ajouter une filière')
@section('page-title', 'Filières')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('filieres.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">Ajouter une filière</h5>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('filieres.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom"
                                   value="{{ old('nom') }}"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   placeholder="Ex: MGSI">
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="code"
                                   value="{{ old('code') }}"
                                   class="form-control @error('code') is-invalid @enderror"
                                   placeholder="Ex: MGSI-S6">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Semestre <span class="text-danger">*</span>
                            </label>
                            <select name="semestre"
                                    class="form-select @error('semestre') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                @for($s = 1; $s <= 6; $s++)
                                    <option value="{{ $s }}"
                                        {{ old('semestre') == $s ? 'selected' : '' }}>
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
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Description de la filière...">{{ old('description') }}</textarea>
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