<x-guest-layout>
    <h2 class="auth-title">Créer un compte</h2>
    <p class="auth-subtitle">Inscription étudiant — Rejoignez votre filière</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nom complet <span class="required">*</span></label>
            <input id="name" class="form-input" type="text" name="name"
                   value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Votre nom complet">
            @if($errors->has('name'))
                <div class="form-error">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email <span class="required">*</span></label>
            <input id="email" class="form-input" type="email" name="email"
                   value="{{ old('email') }}" required autocomplete="username"
                   placeholder="votre@email.com">
            @if($errors->has('email'))
                <div class="form-error">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="filiere_id">Filière <span class="required">*</span></label>
            <select name="filiere_id" id="filiere_id" class="form-select" required>
                <option value="">-- Choisir votre filière --</option>
                @foreach(\App\Models\Filiere::orderBy('nom')->get() as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom }} ({{ $filiere->code }}) — S{{ $filiere->semestre }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('filiere_id'))
                <div class="form-error">{{ $errors->first('filiere_id') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Mot de passe <span class="required">*</span></label>
            <input id="password" class="form-input" type="password" name="password"
                   required autocomplete="new-password" placeholder="••••••••">
            @if($errors->has('password'))
                <div class="form-error">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
            <input id="password_confirmation" class="form-input" type="password"
                   name="password_confirmation" required autocomplete="new-password"
                   placeholder="••••••••">
            @if($errors->has('password_confirmation'))
                <div class="form-error">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>

    <div class="auth-bottom">
        Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</x-guest-layout>