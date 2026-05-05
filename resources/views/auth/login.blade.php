<x-guest-layout>
    <h2 class="auth-title">Bienvenue</h2>
    <p class="auth-subtitle">Connectez-vous à votre compte</p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email" 
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="votre@email.com">
            @if($errors->has('email'))
                <div class="form-error">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Mot de passe</label>
            <input id="password" class="form-input" type="password" name="password" 
                   required autocomplete="current-password" placeholder="••••••••">
            @if($errors->has('password'))
                <div class="form-error">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="flex-between" style="margin-bottom:20px;">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    @if (Route::has('register'))
        <div class="auth-bottom">
            Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    @endif
</x-guest-layout>