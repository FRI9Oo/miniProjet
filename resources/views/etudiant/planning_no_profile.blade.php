@extends('layouts.app')

@section('title', 'Mon planning')
@section('page-title', 'Mon planning')

@section('content')

<div class="card" style="max-width:500px;margin:40px auto">
    <div class="card-body text-center py-5 px-4">
        <div style="width:64px;height:64px;border-radius:50%;background:#fff0f2;
                    display:flex;align-items:center;justify-content:center;
                    margin:0 auto 16px">
            <i class="bi bi-person-x" style="font-size:28px;color:#e94560"></i>
        </div>
        <h6 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:8px">
            Profil non lié
        </h6>
        <p style="font-size:13px;color:#8892a4;line-height:1.7;margin-bottom:0">
            Votre compte n'est pas encore lié à un profil enseignant.<br>
            Contactez l'administrateur pour configurer votre accès.
        </p>
    </div>
</div>

@endsection