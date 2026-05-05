<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EmploisDuTemps') — ENSIASDT</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #1a1a2e;
            --primary-light: #16213e;
            --accent:        #e94560;
            --accent-soft:   rgba(233,69,96,0.12);
            --sidebar-w:     260px;
            --text-muted:    #8892a4;
            --border:        rgba(255,255,255,0.07);
            --card-bg:       #ffffff;
            --page-bg:       #f4f6fb;
            --success:       #0f9b72;
            --warning:       #f59e0b;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            color: #1a1a2e;
            margin: 0;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform .3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: var(--accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            margin-bottom: 12px;
        }

        .sidebar-brand h1 {
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin: 0;
            letter-spacing: .3px;
        }

        .sidebar-brand p {
            font-size: 11px;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        /* User badge */
        .sidebar-user {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 34px; height: 34px;
            background: var(--accent-soft);
            border: 1.5px solid var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: var(--accent);
            font-weight: 600; flex-shrink: 0;
        }

        .user-info .user-name {
            font-size: 13px; font-weight: 500;
            color: #fff; line-height: 1.2;
        }

        .user-info .user-role {
            font-size: 10px;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 600;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
        }

        .nav-section {
            padding: 8px 24px 4px;
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .1em;
            font-weight: 600;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 24px;
            color: #a0aec0;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 400;
            transition: all .2s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .nav-item a:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        .nav-item a.active {
            color: #fff;
            background: var(--accent-soft);
            border-left-color: var(--accent);
            font-weight: 500;
        }

        .nav-item a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        /* Logout */
        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 9px 14px;
            background: rgba(233,69,96,0.1);
            color: var(--accent);
            border: 1px solid rgba(233,69,96,0.25);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: var(--accent);
            color: #fff;
        }

        /* ── MAIN CONTENT ── */
        #main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e8ecf0;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Page content */
        #content {
            flex: 1;
            padding: 32px;
        }

        /* ── CARDS ── */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f2f5;
            padding: 18px 24px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 15px;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            border-radius: 14px;
            padding: 22px 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px; top: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .stat-card .stat-icon {
            font-size: 28px;
            margin-bottom: 12px;
            display: block;
        }

        .stat-card .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 32px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 12px;
            opacity: .8;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* ── ALERTS ── */
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 14px;
        }

        /* ── TABLES ── */
        .table {
            font-size: 14px;
        }

        .table thead th {
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            border-bottom: 2px solid #f0f2f5;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f7f8fa;
        }

        .table tbody tr:hover td {
            background: #fafbfc;
        }

        /* ── BUTTONS ── */
        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 18px;
        }

        .btn-primary:hover {
            background: #d63651;
            border-color: #d63651;
        }

        .btn-sm { font-size: 12px; padding: 5px 12px; }

        /* ── BADGES ── */
        .role-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        /* ── TIMETABLE GRID ── */
        .timetable-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        .timetable-grid th {
            background: var(--primary);
            color: #fff;
            padding: 12px 8px;
            text-align: center;
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .06em;
        }

        .timetable-grid td {
            border: 1px solid #e8ecf0;
            padding: 8px;
            vertical-align: top;
            min-width: 120px;
            height: 80px;
            background: #fff;
        }

        .timetable-grid td:first-child {
            background: #f7f8fa;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-align: center;
            width: 90px;
        }

        .cours-cell {
            background: var(--accent-soft);
            border-left: 3px solid var(--accent);
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 11.5px;
            line-height: 1.4;
        }

        .cours-cell .matiere-name { font-weight: 600; color: var(--primary); }
        .cours-cell .cours-meta { color: var(--text-muted); font-size: 10.5px; }

        /* ── MOBILE ── */
        #sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--primary);
            cursor: pointer;
        }

        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main { margin-left: 0; }
            #content { padding: 20px 16px; }
            #topbar { padding: 0 16px; }
            #sidebar-toggle { display: block; }
            #sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            #sidebar-overlay.show { display: block; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- ── SIDEBAR ── -->
<nav id="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-calendar3"></i></div>
        <h1>EmploisDuTemps</h1>
        <p>ENSIASDT — MGSI S6</p>
    </div>

    <!-- User -->
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ auth()->user()->role }}</div>
        </div>
    </div>

    <!-- Nav -->
    <div class="sidebar-nav">

        <!-- ALL ROLES -->
        <div class="nav-section">Général</div>
        <div class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Tableau de bord
            </a>
        </div>

        <!-- ETUDIANT + ADMIN -->
        @if(auth()->user()->isEtudiant() || auth()->user()->isAdmin())
        <div class="nav-item">
            <a href="{{ route('etudiant.emploi') }}"
               class="{{ request()->routeIs('etudiant.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i> Mon emploi du temps
            </a>
        </div>
        @endif

        <!-- ENSEIGNANT + ADMIN -->
        @if(auth()->user()->isEnseignant()      )
        <div class="nav-item">
            <a href="{{ route('enseignants.planning') }}"
               class="{{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i> Mon planning
            </a>
        </div>
        @endif

        <!-- ADMIN ONLY -->
        @if(auth()->user()->isAdmin())
        <div class="nav-section" style="margin-top:8px">Administration</div>

        <div class="nav-item">
            <a href="{{ route('emplois.index') }}"
               class="{{ request()->routeIs('emplois.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-plus"></i> Emplois du temps
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('enseignants.index') }}"
               class="{{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Enseignants
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('salles.index') }}"
               class="{{ request()->routeIs('salles.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Salles
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('filieres.index') }}"
               class="{{ request()->routeIs('filieres.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i> Filières
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('matieres.index') }}"
               class="{{ request()->routeIs('matieres.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Matières
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('creneaux.index') }}"
               class="{{ request()->routeIs('creneaux.*') ? 'active' : '' }}">
                <i class="bi bi-clock"></i> Créneaux
            </a>
        </div>
        @endif

    </div>

    <!-- Logout -->
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i> Déconnexion
            </button>
        </form>
    </div>

</nav>

<!-- ── MAIN ── -->
<div id="main">

    <!-- Topbar -->
    <div id="topbar">
        <div style="display:flex;align-items:center;gap:14px">
            <button id="sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Tableau de bord')</span>
        </div>
        <div class="topbar-right">
            <span style="font-size:13px;color:#8892a4">
                <i class="bi bi-calendar3 me-1"></i>
                {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
            </span>
        </div>
    </div>

    <!-- Flash messages -->
    <div style="padding: 0 32px; margin-top: 16px;">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Erreurs de validation :</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Page content -->
    <div id="content">
        @yield('content')
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebar-overlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('sidebar-overlay').classList.remove('show');
}
</script>

@stack('scripts')
</body>
</html>