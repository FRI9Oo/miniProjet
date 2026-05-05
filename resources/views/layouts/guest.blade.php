<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ENSIASDT') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg: #1E1E2E;
            --accent: #E94560;
            --muted: #9499C3;
            --white: #FFFFFF;
            --card: rgba(148, 153, 195, 0.04);
            --border: rgba(148, 153, 195, 0.12);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--bg);
            color: var(--white);
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }
        /* Floating shapes */
        .shapes {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.03;
            animation: float 20s infinite ease-in-out;
        }
        .shape:nth-child(1) { width: 500px; height: 500px; background: var(--accent); top: -150px; left: -150px; }
        .shape:nth-child(2) { width: 350px; height: 350px; background: #534ab7; bottom: -100px; right: -100px; animation-delay: -7s; }
        .shape:nth-child(3) { width: 200px; height: 200px; background: var(--accent); top: 40%; left: 60%; animation-delay: -12s; }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(30px, -20px) rotate(5deg); }
        }
        /* Card */
        .auth-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px 32px;
            backdrop-filter: blur(10px);
        }
        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 32px;
            text-decoration: none;
        }
        .auth-logo-icon {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .auth-logo-text {
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.5px;
        }
        .auth-title {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
            color: var(--white);
        }
        .auth-subtitle {
            font-size: 13px;
            color: var(--muted);
            text-align: center;
            margin-bottom: 28px;
        }
        /* Form elements */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .form-label .required { color: var(--accent); }
        .form-input, .form-select {
            width: 100%;
            padding: 12px 16px;
            background: rgba(148, 153, 195, 0.06);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--white);
            font-size: 14px;
            font-family: 'Figtree', sans-serif;
            transition: all 0.2s;
            outline: none;
        }
        .form-input::placeholder { color: rgba(148, 153, 195, 0.4); }
        .form-input:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }
        .form-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239499C3' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
        }
        .form-select option {
            background: #1E1E2E;
            color: var(--white);
        }
        .form-error {
            font-size: 12px;
            color: var(--accent);
            margin-top: 4px;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .form-check input[type="checkbox"] {
            accent-color: var(--accent);
            width: 16px; height: 16px;
        }
        .form-check label {
            font-size: 13px;
            color: var(--muted);
            cursor: pointer;
        }
        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: all 0.25s;
            font-family: 'Figtree', sans-serif;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-primary {
            background: var(--accent);
            color: var(--white);
            width: 100%;
        }
        .btn-primary:hover { background: #D63850; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,69,96,0.3); }
        .auth-link {
            color: var(--muted);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .auth-link:hover { color: var(--accent); }
        .auth-bottom {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--muted);
        }
        .auth-bottom a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-bottom a:hover { text-decoration: underline; }
        .flex-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    <div class="shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="/" class="auth-logo">
                <div class="auth-logo-icon">📅</div>
                <span class="auth-logo-text">ENSIASDT</span>
            </a>
            {{ $slot }}
        </div>
    </div>

</body>
</html>