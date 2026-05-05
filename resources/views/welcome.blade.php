<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ENSIASDT — Gestion des Emplois du Temps</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <style>
        :root {
            --bg: #1E1E2E;
            --accent: #E94560;
            --muted: #9499C3;
            --white: #FFFFFF;
            --card: rgba(148, 153, 195, 0.05);
            --border: rgba(148, 153, 195, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg);
            color: var(--white);
            font-family: 'Figtree', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Floating geometric shapes */
        .shapes {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.04;
            animation: float 20s infinite ease-in-out;
        }
        .shape:nth-child(1) { width: 600px; height: 600px; background: var(--accent); top: -200px; left: -200px; animation-delay: 0s; }
        .shape:nth-child(2) { width: 400px; height: 400px; background: #534ab7; bottom: -100px; right: -100px; animation-delay: -5s; }
        .shape:nth-child(3) { width: 300px; height: 300px; background: var(--accent); top: 50%; left: 50%; animation-delay: -10s; }
        .shape:nth-child(4) { width: 200px; height: 200px; background: #0f9b72; top: 20%; right: 10%; animation-delay: -15s; }
        .shape:nth-child(5) { width: 250px; height: 250px; background: #f59e0b; bottom: 30%; left: 5%; animation-delay: -7s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(40px, -30px) rotate(5deg); }
            50% { transform: translate(-20px, 20px) rotate(-3deg); }
            75% { transform: translate(30px, 10px) rotate(2deg); }
        }

        /* Grid pattern overlay */
        .grid-pattern {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0;
            background-image:
                linear-gradient(rgba(148,153,195,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,153,195,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Content */
        .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Nav */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid var(--border);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .logo-icon {
            width: 42px; height: 42px;
            background: var(--accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--white);
        }
        .logo-text {
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.5px;
        }
        .nav-btns { display: flex; gap: 12px; align-items: center; }
        .btn {
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.25s;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary {
            background: var(--accent);
            color: var(--white);
        }
        .btn-primary:hover { background: #D63850; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(233,69,96,0.3); }
        .btn-outline {
            background: transparent;
            color: var(--white);
            border: 1px solid var(--border);
        }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }

        /* Hero */
        .hero {
            padding: 80px 0 60px;
            display: flex;
            align-items: center;
            gap: 60px;
            min-height: 70vh;
        }
        .hero-content { flex: 1; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(233,69,96,0.1);
            border: 1px solid rgba(233,69,96,0.25);
            border-radius: 50px;
            color: var(--accent);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(233,69,96,0.3); }
            50% { box-shadow: 0 0 0 12px rgba(233,69,96,0); }
        }
        .hero-badge .dot {
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
        .hero h1 {
            font-size: clamp(36px, 6vw, 64px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--accent), #ff6b81);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            font-size: 17px;
            color: var(--muted);
            line-height: 1.7;
            max-width: 500px;
            margin-bottom: 32px;
        }
        .hero-buttons { display: flex; gap: 14px; flex-wrap: wrap; }

        /* Hero visual */
        .hero-visual {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .floating-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            transform: rotate(-3deg);
            animation: floatCard 6s infinite ease-in-out;
        }
        @keyframes floatCard {
            0%, 100% { transform: rotate(-3deg) translateY(0); }
            50% { transform: rotate(-3deg) translateY(-15px); }
        }
        .floating-card .day {
            font-size: 12px;
            color: var(--accent);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }
        .floating-card .course {
            background: rgba(83,74,183,0.2);
            border-left: 3px solid #534ab7;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .floating-card .course-name {
            font-weight: 700;
            font-size: 14px;
            color: var(--white);
        }
        .floating-card .course-meta {
            font-size: 11px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* Features */
        .features {
            padding: 80px 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 3px;
            background: var(--accent);
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-card:hover { border-color: var(--accent); transform: translateY(-4px); }
        .feature-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }
        .feature-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 8px; color: var(--white); }
        .feature-card p { font-size: 13px; color: var(--muted); line-height: 1.6; }

        /* Stats strip */
        .stats-strip {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 50px 0;
            flex-wrap: wrap;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            margin: 40px 0;
        }
        .stat-item { text-align: center; }
        .stat-number {
            font-size: 36px;
            font-weight: 900;
            color: var(--accent);
        }
        .stat-label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 40px 0;
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .hero { flex-direction: column; padding: 40px 0; text-align: center; }
            .hero p { max-width: 100%; }
            .hero-buttons { justify-content: center; }
            .hero-visual { display: none; }
            .features { grid-template-columns: 1fr; }
            .stats-strip { gap: 24px; }
        }
    </style>
</head>
<body>

    <!-- Floating Shapes -->
    <div class="shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="grid-pattern"></div>

    <div class="container">
        <!-- Navigation -->
        <nav>
            <a href="/" class="logo">
                <div class="logo-icon">📅</div>
                <span class="logo-text">ENSIASDT</span>
            </a>
            <div class="nav-btns">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                    @endif
                @endauth
            </div>
        </nav>

        <!-- Hero -->
        <section class="hero">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="dot"></span> Mini-Projet — Développement Web
                </div>
                <h1>
                    Vos emplois du temps,
                    <span class="highlight">simplifiés.</span>
                </h1>
                <p>
                    Planifiez, visualisez et gérez les emplois du temps de l'ENSIASDT avec une interface moderne. 
                    Détection automatique des conflits, export PDF et suivi en temps réel.
                </p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Accéder au dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Commencer maintenant →
                        </a>
                        <a href="#features" class="btn btn-outline">Découvrir</a>
                    @endif
                </div>
            </div>
            <div class="hero-visual">
                <div class="floating-card">
                    <div class="day">📅 Lundi</div>
                    <div class="course">
                        <div class="course-name">Développement Web</div>
                        <div class="course-meta">👨‍🏫 Pr. El Amrani · 🏫 Salle 201</div>
                    </div>
                    <div class="course">
                        <div class="course-name">Algorithmique</div>
                        <div class="course-meta">👩‍🏫 Pr. Chakir · 🏫 Labo TP 1</div>
                    </div>
                    <div class="course">
                        <div class="course-name">Bases de Données</div>
                        <div class="course-meta">👨‍🏫 Pr. Idrissi · 🏫 Amphi</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Strip -->
        <div class="stats-strip">
            <div class="stat-item">
                <div class="stat-number">{{ $stats['filieres'] }}</div>
                <div class="stat-label">Filières</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['enseignants'] }}</div>
                <div class="stat-label">Enseignants</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['salles'] }}</div>
                <div class="stat-label">Salles</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['cours'] }}</div>
                <div class="stat-label">Cours planifiés</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">✓</div>
                <div class="stat-label">Anti-conflit</div>
            </div>
        </div>

        <!-- Features -->
        <section id="features" class="features">
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(233,69,96,0.12);color:#E94560;">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <h3>Planning Hebdomadaire</h3>
                <p>Grille claire et intuitive couvrant du Lundi au Samedi avec tous les créneaux.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(233,69,96,0.12);color:#E94560;">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <h3>Détection de Conflits</h3>
                <p>Vérification automatique des chevauchements enseignants, salles et filières.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(233,69,96,0.12);color:#E94560;">
                    <i class="bi bi-printer"></i>
                </div>
                <h3>Export PDF</h3>
                <p>Générez et imprimez les plannings en un clic. Format optimisé pour l'impression.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:rgba(233,69,96,0.12);color:#E94560;">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Multi-rôles</h3>
                <p>Admin, enseignant et étudiant : chaque rôle a une vue adaptée à ses besoins.</p>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <p>© {{ date('Y') }} ENSIASDT — Mini-Projet Développement Web</p>
            <p style="margin-top:4px;font-size:11px;">Laravel v{{ Illuminate\Foundation\Application::VERSION }} · PHP v{{ PHP_VERSION }}</p>
        </footer>
    </div>

</body>
</html>