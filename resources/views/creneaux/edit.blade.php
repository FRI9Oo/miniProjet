@extends('layouts.app')

@section('title', 'Modifier un créneau')
@section('page-title', 'Créneaux horaires')

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('creneaux.index') }}" class="btn btn-sm" style="background:#f0f2f5;color:#444">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0" style="font-family:'Syne',sans-serif;font-weight:700">
        Modifier — {{ $creneau->jour }} {{ substr($creneau->heure_debut,0,5) }}–{{ substr($creneau->heure_fin,0,5) }}
    </h5>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('creneaux.update', $creneau) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Jour <span class="text-danger">*</span>
                            </label>
                            <select name="jour"
                                    class="form-select @error('jour') is-invalid @enderror">
                                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
                                    <option value="{{ $jour }}"
                                        {{ old('jour', $creneau->jour) == $jour ? 'selected' : '' }}>
                                        {{ $jour }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jour')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Heure début <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="heure_debut"
                                   value="{{ old('heure_debut', substr($creneau->heure_debut,0,5)) }}"
                                   class="form-control @error('heure_debut') is-invalid @enderror">
                            @error('heure_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Heure fin <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="heure_fin"
                                   value="{{ old('heure_fin', substr($creneau->heure_fin,0,5)) }}"
                                   class="form-control @error('heure_fin') is-invalid @enderror">
                            @error('heure_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-size:13px;font-weight:500">
                                Libellé
                            </label>
                            <input type="text" name="libelle"
                                   value="{{ old('libelle', $creneau->libelle) }}"
                                   class="form-control @error('libelle') is-invalid @enderror">
                            @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                        <a href="{{ route('creneaux.index') }}"
                           class="btn" style="background:#f0f2f5;color:#444">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection