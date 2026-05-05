<x-guest-layout>
    <h2 class="auth-title">Mot de passe oublié</h2>
    <p class="auth-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email" 
                   value="{{ old('email') }}" required autofocus placeholder="votre@email.com">
            @if($errors->has('email'))
                <div class="form-error">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Envoyer le lien</button>
    </form>

    <div class="auth-bottom">
        <a href="{{ route('login') }}">← Retour à la connexion</a>
    </div>
</x-guest-layout>