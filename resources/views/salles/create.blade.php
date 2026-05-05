    @extends('layouts.app')

@section('title', 'Ajouter une salle')
@section('page-title', 'Salles')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('salles.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">Ajouter une salle</h5>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('salles.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom"
                                   value="{{ old('nom') }}"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   placeholder="Ex: Salle A1">
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="code"
                                   value="{{ old('code') }}"
                                   class="form-control @error('code') is-invalid @enderror"
                                   placeholder="Ex: A1">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Type <span class="text-danger">*</span>
                            </label>
                            <select name="type"
                                    class="form-select @error('type') is-invalid @enderror">
                                <option value="">-- Choisir --</option>
                                @foreach(['cours','td','tp','amphi'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ strtoupper($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Capacité <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="capacite"
                                   value="{{ old('capacite', 30) }}"
                                   min="1" max="1000"
                                   class="form-control @error('capacite') is-invalid @enderror">
                            @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                       name="disponible" value="1" id="disponible"
                                       {{ old('disponible', '1') ? 'checked' : '' }}>
                                <label class="form-check-label" for="disponible"
                                       style="font-size:13px">
                                    Salle disponible
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('salles.index') }}"
                           class="btn" style="background:#f0f2f5;color:#444">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection