<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace — Elyon Consulting</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           VARIABLES GLOBALES
        ═══════════════════════════════════════════ */
        :root {
            --primary:       #0a2463;
            --primary-light: #1e40af;
            --accent:        #f0a500;
            --accent-light:  #fbbf24;
            --dark:          #07152b;
            --text:          #1e293b;
            --muted:         #64748b;
            --light-bg:      #f1f5f9;
            --white:         #ffffff;
            --border:        #e2e8f0;
            --success:       #10b981;
            --danger:        #ef4444;
            --warning:       #f59e0b;
            --font-display:  'Playfair Display', serif;
            --font-body:     'DM Sans', sans-serif;
            --sidebar-w:     270px;
            --topbar-h:      72px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-body); color: var(--text); background: var(--light-bg); min-height: 100vh; }

        /* ═══════════════════════════════════════════
           TOPBAR — Barre fixe en haut
        ═══════════════════════════════════════════ */
        .ec-topbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--topbar-h);
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            z-index: 1000;
            display: flex; align-items: center;
            padding: 0 1.5rem; gap: 1rem;
            justify-content: space-between;
        }
        .topbar-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .topbar-brand img { height: 40px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.10); }
        .brand-name { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); }
        .brand-sub { font-size: 0.7rem; color: var(--muted); }
        .topbar-user { display: flex; align-items: center; gap: 0.75rem; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
        .user-greeting { font-size: 0.88rem; font-weight: 600; color: var(--text); }
        .user-role { font-size: 0.72rem; color: var(--muted); }
        .sidebar-toggle { background: none; border: 1px solid var(--border); border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: var(--text); cursor: pointer; transition: all 0.2s; }
        .sidebar-toggle:hover { background: var(--light-bg); }

        /* ═══════════════════════════════════════════
           LAYOUT PRINCIPAL
        ═══════════════════════════════════════════ */
        .client-layout { display: flex; min-height: 100vh; padding-top: var(--topbar-h); }

        /* ═══════════════════════════════════════════
           SIDEBAR — Navigation latérale
        ═══════════════════════════════════════════ */
        .client-sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--primary), var(--dark));
            position: fixed; top: var(--topbar-h); left: 0; bottom: 0;
            z-index: 100; display: flex; flex-direction: column;
            padding: 1.5rem 1rem; overflow-y: auto; transition: transform 0.3s ease;
        }
        .sidebar-profile { display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: rgba(255,255,255,0.07); border-radius: 14px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 1.5rem; }
        .sidebar-avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); flex-shrink: 0; }
        .sidebar-name { font-size: 0.88rem; font-weight: 700; color: white; line-height: 1.2; }
        .sidebar-email { font-size: 0.72rem; color: rgba(255,255,255,0.55); }
        .menu-group-title { font-size: 0.65rem; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.35); font-weight: 700; padding: 0 0.5rem; margin: 1rem 0 0.5rem; }
        .sidebar-nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 12px; color: rgba(255,255,255,0.75); text-decoration: none; font-size: 0.88rem; font-weight: 500; transition: all 0.25s ease; margin-bottom: 0.25rem; }
        .sidebar-nav-link:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-nav-link.active { background: rgba(30,64,175,0.5); color: white; box-shadow: 0 4px 16px rgba(10,36,99,0.3); border: 1px solid rgba(30,64,175,0.4); }
        .sidebar-nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        .menu-badge { background: var(--accent); color: white; font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 999px; margin-left: auto; }
        .sidebar-footer { margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); }
        .btn-logout { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 12px; color: rgba(255,100,100,0.85); background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: all 0.25s; width: 100%; text-align: left; }
        .btn-logout:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }

        /* ═══════════════════════════════════════════
           CONTENU PRINCIPAL
        ═══════════════════════════════════════════ */
        .client-main { margin-left: var(--sidebar-w); flex: 1; padding: 2rem; overflow-x: hidden; }
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-family: var(--font-display); font-size: 1.75rem; font-weight: 800; color: var(--primary); margin-bottom: 0.25rem; }
        .page-header p { font-size: 0.9rem; color: var(--muted); margin: 0; }

        /* ═══════════════════════════════════════════
           STAT CARDS — Cartes de statistiques
        ═══════════════════════════════════════════ */
        .stat-card { background: white; border-radius: 18px; padding: 1.5rem; border: 1px solid var(--border); box-shadow: 0 4px 16px rgba(10,36,99,0.06); display: flex; align-items: center; gap: 1rem; transition: transform 0.3s ease, box-shadow 0.3s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(10,36,99,0.12); }
        .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon i { font-size: 1.4rem; color: white; }
        .stat-number { font-family: var(--font-display); font-size: 1.8rem; font-weight: 800; color: var(--primary); line-height: 1; }
        .stat-label { font-size: 0.82rem; color: var(--muted); font-weight: 500; }
        .stat-primary { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
        .stat-success { background: linear-gradient(135deg, var(--success), #059669); }
        .stat-warning { background: linear-gradient(135deg, var(--warning), #d97706); }
        .stat-danger  { background: linear-gradient(135deg, var(--danger), #dc2626); }

        /* ═══════════════════════════════════════════
           EC CARD — Cartes de contenu
        ═══════════════════════════════════════════ */
        .ec-card { background: white; border-radius: 18px; border: 1px solid var(--border); box-shadow: 0 4px 16px rgba(10,36,99,0.06); overflow: hidden; }
        .ec-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .ec-card-header h3 { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 0.5rem; }
        .ec-card-body { padding: 1.5rem; }

        /* ═══════════════════════════════════════════
           BADGES STATUT DOSSIER
        ═══════════════════════════════════════════ */
        .status-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.75rem; border-radius: 999px; font-size: 0.78rem; font-weight: 700; }
        .status-en_attente { background: rgba(245,158,11,0.12); color: #92400e; }
        .status-en_cours   { background: rgba(59,130,246,0.12);  color: #1d4ed8; }
        .status-valide     { background: rgba(16,185,129,0.12);  color: #065f46; }
        .status-refuse     { background: rgba(239,68,68,0.12);   color: #991b1b; }

        /* ═══════════════════════════════════════════
           TABLE DOSSIERS
        ═══════════════════════════════════════════ */
        .dossier-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .dossier-table thead th { background: var(--primary); color: white; font-size: 0.8rem; font-weight: 600; padding: 0.9rem 1rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .dossier-table thead th:first-child { border-radius: 12px 0 0 0; }
        .dossier-table thead th:last-child  { border-radius: 0 12px 0 0; }
        .dossier-table tbody td { padding: 1rem; font-size: 0.88rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .dossier-table tbody tr:last-child td { border-bottom: none; }
        .dossier-table tbody tr:hover td { background: #f8fafc; }
        .btn-table { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.85rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; }
        .btn-table-primary { background: rgba(10,36,99,0.08); color: var(--primary); }
        .btn-table-primary:hover { background: var(--primary); color: white; }

        /* ═══════════════════════════════════════════
           FORMULAIRES
        ═══════════════════════════════════════════ */
        .form-ec label { font-size: 0.82rem; font-weight: 600; color: var(--text); margin-bottom: 0.4rem; display: block; }
        .form-ec .form-control, .form-ec .form-select { border-radius: 10px; border: 1px solid var(--border); font-size: 0.9rem; padding: 0.65rem 0.9rem; transition: all 0.25s; background: #fafbfc; }
        .form-ec .form-control:focus, .form-ec .form-select:focus { border-color: var(--primary-light); box-shadow: 0 0 0 0.2rem rgba(30,64,175,0.12); background: white; }
        .btn-form-submit { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; border-radius: 10px; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; text-decoration: none; }
        .btn-form-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(10,36,99,0.25); color: white; }

        /* ═══════════════════════════════════════════
           ALERTES
        ═══════════════════════════════════════════ */
        .ec-alert { display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem 1.25rem; border-radius: 12px; font-size: 0.88rem; margin-bottom: 1rem; }
        .ec-alert-warning { background: rgba(245,158,11,0.1);  border: 1px solid rgba(245,158,11,0.3); color: #92400e; }
        .ec-alert-success { background: rgba(16,185,129,0.1);  border: 1px solid rgba(16,185,129,0.3); color: #065f46; }
        .ec-alert-info    { background: rgba(30,64,175,0.08);  border: 1px solid rgba(30,64,175,0.2);  color: var(--primary); }
        .ec-alert-danger  { background: rgba(239,68,68,0.08);  border: 1px solid rgba(239,68,68,0.2);  color: #991b1b; }

        /* ═══════════════════════════════════════════
           PROFIL CLIENT
        ═══════════════════════════════════════════ */
        .profile-header { display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 18px; color: white; margin-bottom: 1.5rem; }
        .profile-avatar-wrap { position: relative; width: 90px; height: 90px; flex-shrink: 0; }
        .profile-avatar-wrap img { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.5); }
        .profile-avatar-btn { position: absolute; bottom: 2px; right: 2px; width: 28px; height: 28px; border-radius: 50%; background: #3b82f6; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid #fff; font-size: 12px; }
        .profile-name-heading { font-family: var(--font-display); font-size: 1.3rem; font-weight: 800; }
        .profile-sub { font-size: 0.85rem; color: rgba(255,255,255,0.75); }
        .profile-badge { display: inline-block; background: rgba(240,165,0,0.2); border: 1px solid rgba(240,165,0,0.4); color: var(--accent-light); font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 700; margin-top: 0.4rem; }

        /* ═══════════════════════════════════════════
           RESPONSIVE — Mobile
        ═══════════════════════════════════════════ */
        @media (max-width: 991px) {
            .client-sidebar { transform: translateX(-100%); }
            .client-sidebar.open { transform: translateX(0); }
            .client-main { margin-left: 0; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 99; }
            .sidebar-overlay.active { display: block; }
        }
        @media (max-width: 576px) { .client-main { padding: 1rem; } }
    </style>
</head>
<body>

{{-- ════════════════════════════════════════════════
     TOPBAR — Barre de navigation supérieure fixe
════════════════════════════════════════════════ --}}
<header class="ec-topbar">
    <div class="d-flex align-items-center gap-3">
        {{-- Bouton burger visible uniquement sur mobile --}}
        <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <a class="topbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Elyon">
            <div>
                <div class="brand-name">Elyon Consulting</div>
                <div class="brand-sub">Espace Client</div>
            </div>
        </a>
    </div>
    <div class="topbar-user">
        {{-- Avatar mis à jour dynamiquement via JS après changement --}}
        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/avatar.png') }}"
             class="user-avatar" alt="Avatar" id="topbarAvatarClient">
        <div class="d-none d-md-block">
            <div class="user-greeting">{{ auth()->user()->name }}</div>
            <div class="user-role">Client</div>
        </div>
    </div>
</header>

{{-- Overlay sombre pour fermer la sidebar sur mobile --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="client-layout">

    {{-- ════════════════════════════════════════════════
         SIDEBAR — Navigation latérale
    ════════════════════════════════════════════════ --}}
    <aside class="client-sidebar" id="clientSidebar">

        {{-- Profil résumé en haut de la sidebar --}}
        <div class="sidebar-profile">
            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/avatar.png') }}"
                 class="sidebar-avatar" alt="Avatar" id="sidebarAvatarClient">
            <div>
                <div class="sidebar-name">{{ Str::limit(auth()->user()->name, 18) }}</div>
                <div class="sidebar-email">{{ Str::limit(auth()->user()->email, 22) }}</div>
            </div>
        </div>

        {{-- Liens de navigation principaux --}}
        <div class="menu-group-title">Menu principal</div>
        <a class="sidebar-nav-link active" id="link-dashboard" href="#"
           onclick="showSection('dashboard', this); return false;">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        <a class="sidebar-nav-link" id="link-dossiers" href="#"
           onclick="showSection('dossiers', this); return false;">
            <i class="bi bi-folder2"></i> Mes dossiers
            {{-- Badge avec le nombre de dossiers --}}
            @if($stats['total'] > 0)
                <span class="menu-badge">{{ $stats['total'] }}</span>
            @endif
        </a>

        {{-- Liens secondaires --}}
        <div class="menu-group-title">Compte</div>
        <a class="sidebar-nav-link" id="link-profil" href="#"
           onclick="showSection('profil', this); return false;">
            <i class="bi bi-person-circle"></i> Mon profil
        </a>
        <a class="sidebar-nav-link" href="{{ route('services.index') }}">
            <i class="bi bi-globe"></i> Voir les services
        </a>
        <a class="sidebar-nav-link" href="{{ route('home') }}">
            <i class="bi bi-house"></i> Retour à l'accueil
        </a>

        {{-- Bouton déconnexion en bas de la sidebar --}}
        <div class="sidebar-footer">
            <button class="btn-logout" onclick="document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Se déconnecter
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </aside>

    {{-- ════════════════════════════════════════════════
         CONTENU PRINCIPAL
    ════════════════════════════════════════════════ --}}
    <main class="client-main">

        {{-- Messages flash globaux affichés en haut --}}
        @if(session('success'))
            <div class="ec-alert ec-alert-success mb-3">
                <i class="bi bi-check-circle-fill" style="flex-shrink:0;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="ec-alert ec-alert-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
                {{ session('error') }}
            </div>
        @endif
        @if(session('password_success'))
            <div class="ec-alert ec-alert-success mb-3">
                <i class="bi bi-check-circle-fill" style="flex-shrink:0;"></i>
                {{ session('password_success') }}
            </div>
        @endif

        {{-- ════════════════════════════════════════
             SECTION 1 : TABLEAU DE BORD
             Affichée par défaut au chargement
        ════════════════════════════════════════ --}}
        <div id="section-dashboard" class="client-section">

            <div class="page-header" data-aos="fade-up">
                <h1>Tableau de bord</h1>
                <p>Bienvenue {{ auth()->user()->name }}, voici un résumé de votre activité.</p>
            </div>

            {{-- 4 cartes de statistiques --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-card">
                        <div class="stat-icon stat-primary"><i class="bi bi-folder2"></i></div>
                        <div>
                            <div class="stat-number">{{ $stats['total'] }}</div>
                            <div class="stat-label">Total dossiers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="80">
                    <div class="stat-card">
                        <div class="stat-icon stat-warning"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="stat-number">{{ $stats['en_cours'] + $stats['attente'] }}</div>
                            <div class="stat-label">En cours</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="160">
                    <div class="stat-card">
                        <div class="stat-icon stat-success"><i class="bi bi-check-circle"></i></div>
                        <div>
                            <div class="stat-number">{{ $stats['valides'] }}</div>
                            <div class="stat-label">Validés</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="240">
                    <div class="stat-card">
                        <div class="stat-icon stat-danger"><i class="bi bi-x-circle"></i></div>
                        <div>
                            <div class="stat-number">{{ $stats['refuses'] }}</div>
                            <div class="stat-label">Refusés</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tableau des 5 derniers dossiers --}}
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-clock-history text-primary"></i> Dossiers récents</h3>
                    <a href="#" onclick="showSection('dossiers', document.getElementById('link-dossiers')); return false;"
                       style="font-size:0.85rem; color:var(--primary-light); text-decoration:none; font-weight:600;">
                        Voir tous <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="ec-card-body p-0">
                    @if($dossiers->isNotEmpty())
                        <div class="table-responsive">
                            <table class="dossier-table">
                                <thead>
                                    <tr><th>Service</th><th>Pays</th><th>Statut</th><th>Date</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($dossiers->take(5) as $dossier)
                                        <tr>
                                            <td style="font-weight:600;">{{ $dossier->service->nom ?? '—' }}</td>
                                            <td>{{ $dossier->service->pays ?? '—' }}</td>
                                            <td>
                                                <span class="status-badge status-{{ $dossier->statut }}">
                                                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $dossier->statut)) }}
                                                </span>
                                            </td>
                                            <td style="color:var(--muted); font-size:0.85rem;">
                                                {{ $dossier->created_at->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- État vide : aucun dossier --}}
                        <div class="text-center py-5" style="color:var(--muted);">
                            <i class="bi bi-folder2-open" style="font-size:2.5rem; display:block; margin-bottom:0.75rem;"></i>
                            <p>Vous n'avez aucun dossier pour le moment.</p>
                            <a href="#" onclick="showSection('dossiers', document.getElementById('link-dossiers')); return false;"
                               class="btn-form-submit mt-2">
                                <i class="bi bi-plus-circle"></i> Créer mon premier dossier
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Conseil pour les nouveaux utilisateurs --}}
            <div class="ec-alert ec-alert-info mt-4" data-aos="fade-up">
                <i class="bi bi-info-circle-fill" style="font-size:1.1rem; flex-shrink:0;"></i>
                <div>
                    <strong>Nouveau ici ?</strong> Commencez par
                    <strong>choisir un service</strong> dans l'onglet "Mes dossiers"
                    pour créer votre premier dossier de visa.
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════
             SECTION 2 : MES DOSSIERS
             Création + liste complète avec lien détail
        ════════════════════════════════════════ --}}
        <div id="section-dossiers" class="client-section d-none">

            <div class="page-header" data-aos="fade-up">
                <h1>Mes Dossiers</h1>
                <p>Gérez vos dossiers de demande de visa et suivez leur avancement.</p>
            </div>

            {{-- Formulaire de création d'un nouveau dossier --}}
            <div class="ec-card mb-4" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-plus-circle text-success"></i> Créer un nouveau dossier</h3>
                </div>
                <div class="ec-card-body">

                    <div class="ec-alert ec-alert-info mb-3">
                        <i class="bi bi-info-circle-fill" style="flex-shrink:0;"></i>
                        <div>
                            Choisissez un service parmi ceux disponibles.
                            Notre équipe traitera votre dossier sous <strong>24h</strong>.
                        </div>
                    </div>

                    <form action="{{ route('client.dossiers.store') }}" method="POST" class="form-ec">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label>Choisir un service *</label>
                                <select name="service_id"
                                        class="form-select @error('service_id') is-invalid @enderror"
                                        required>
                                    <option value="">— Sélectionnez un service —</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom }} — {{ $service->pays }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn-form-submit w-100">
                                    <i class="bi bi-folder-plus"></i> Créer le dossier
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Liste complète des dossiers --}}
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-folder2-open text-primary"></i> Tous mes dossiers</h3>
                    <span style="font-size:0.82rem; color:var(--muted);">{{ $dossiers->count() }} dossier(s)</span>
                </div>
                <div class="ec-card-body p-0">
                    @if($dossiers->isNotEmpty())
                        <div class="table-responsive">
                            <table class="dossier-table">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Pays</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dossiers as $dossier)
                                        <tr>
                                            <td style="font-weight:600;">{{ $dossier->service->nom ?? '—' }}</td>
                                            <td>{{ $dossier->service->pays ?? '—' }}</td>
                                            <td>
                                                <span class="status-badge status-{{ $dossier->statut }}">
                                                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $dossier->statut)) }}
                                                </span>
                                            </td>
                                            <td style="color:var(--muted); font-size:0.85rem;">
                                                {{ $dossier->created_at->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                {{-- Lien vers la page de détail complète du dossier --}}
                                                <a href="{{ route('client.dossiers.show', $dossier->id) }}"
                                                   class="btn-table btn-table-primary">
                                                    <i class="bi bi-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- État vide --}}
                        <div class="text-center py-5" style="color:var(--muted);">
                            <i class="bi bi-inbox" style="font-size:2.5rem; display:block; margin-bottom:0.75rem;"></i>
                            <p>Aucun dossier créé pour le moment.</p>
                            <p style="font-size:0.85rem;">Utilisez le formulaire ci-dessus pour créer votre premier dossier.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════
             SECTION 3 : MON PROFIL
             Modification des infos + changement avatar + mot de passe
        ════════════════════════════════════════ --}}
        <div id="section-profil" class="client-section d-none">

            <div class="page-header" data-aos="fade-up">
                <h1>Mon Profil</h1>
                <p>Consultez et modifiez vos informations personnelles.</p>
            </div>

            {{-- Bannière profil avec avatar modifiable --}}
            <div class="profile-header" data-aos="fade-up">
                <div class="profile-avatar-wrap">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/avatar.png') }}"
                         alt="Avatar" id="profileAvatarPreview">
                    {{-- Formulaire discret pour changer l'avatar via le bouton caméra --}}
                    <form action="{{ route('client.avatar.update') }}" method="POST"
                          enctype="multipart/form-data" id="clientAvatarForm">
                        @csrf
                        <label class="profile-avatar-btn" title="Changer la photo">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="avatar" hidden
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   onchange="previewClientAvatar(this)">
                        </label>
                    </form>
                </div>
                <div>
                    <div class="profile-name-heading">{{ auth()->user()->name }}</div>
                    <div class="profile-sub">{{ auth()->user()->email }}</div>
                    <div class="profile-sub">{{ auth()->user()->telephone ?? 'Téléphone non renseigné' }}</div>
                    <span class="profile-badge">Client</span>
                </div>
            </div>

            {{-- Bouton de sauvegarde de l'avatar (apparaît après sélection d'un fichier) --}}
            <div id="clientAvatarSaveBtn" class="d-none mb-3">
                <button type="button" onclick="document.getElementById('clientAvatarForm').submit();"
                        class="btn-form-submit">
                    <i class="bi bi-floppy me-1"></i> Sauvegarder la photo
                </button>
            </div>

            {{-- Onglets : Informations | Mot de passe --}}
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <ul class="nav nav-pills gap-2 mb-0" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill"
                                    data-bs-target="#pane-infos-client" type="button"
                                    style="font-size:0.85rem; border-radius:8px; padding:6px 14px;">
                                <i class="bi bi-person me-1"></i> Mes informations
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="tab-pwd-client"
                                    data-bs-toggle="pill" data-bs-target="#pane-pwd-client"
                                    type="button"
                                    style="font-size:0.85rem; border-radius:8px; padding:6px 14px;">
                                <i class="bi bi-lock me-1"></i> Mot de passe
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="ec-card-body">
                    <div class="tab-content">

                        {{-- ── Onglet 1 : Informations personnelles ── --}}
                        <div class="tab-pane fade show active" id="pane-infos-client" role="tabpanel">

                            @if(session('profile_success'))
                                <div class="ec-alert ec-alert-success mb-3">
                                    <i class="bi bi-check-circle-fill"></i> {{ session('profile_success') }}
                                </div>
                            @endif

                            <form action="{{ route('client.profile.update') }}" method="POST" class="form-ec">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>Nom complet</label>
                                        <input type="text" name="name"
                                               value="{{ old('name', auth()->user()->name) }}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Adresse email</label>
                                        <input type="email" name="email"
                                               value="{{ old('email', auth()->user()->email) }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Téléphone <span style="color:var(--muted); font-size:0.75rem;">(optionnel)</span></label>
                                        <input type="text" name="telephone"
                                               value="{{ old('telephone', auth()->user()->telephone) }}"
                                               class="form-control"
                                               placeholder="+242 06 000 00 00">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-form-submit">
                                            <i class="bi bi-floppy me-1"></i> Enregistrer les modifications
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- ── Onglet 2 : Changement de mot de passe ── --}}
                        <div class="tab-pane fade" id="pane-pwd-client" role="tabpanel">

                            @if(session('password_success'))
                                <div class="ec-alert ec-alert-success mb-3">
                                    <i class="bi bi-check-circle-fill"></i> {{ session('password_success') }}
                                </div>
                            @endif

                            <div class="ec-alert ec-alert-info mb-3">
                                <i class="bi bi-info-circle-fill" style="flex-shrink:0;"></i>
                                <div>Choisissez un mot de passe sécurisé d'au moins <strong>8 caractères</strong>.</div>
                            </div>

                            @error('current_password')
                                <div class="ec-alert ec-alert-danger mb-3">
                                    <i class="bi bi-x-circle-fill" style="flex-shrink:0;"></i> {{ $message }}
                                </div>
                            @enderror

                            <form action="{{ route('password.change') }}" method="POST" class="form-ec">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label>Mot de passe actuel</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password" id="clientCurrentPwd"
                                                   class="form-control @error('current_password') is-invalid @enderror"
                                                   style="border-radius:10px 0 0 10px;"
                                                   placeholder="Mot de passe actuel" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                    onclick="toggleClientPwd('clientCurrentPwd', this)"
                                                    style="border-radius:0 10px 10px 0;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nouveau mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="clientNewPwd"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   style="border-radius:10px 0 0 10px;"
                                                   placeholder="Minimum 8 caractères" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                    onclick="toggleClientPwd('clientNewPwd', this)"
                                                    style="border-radius:0 10px 10px 0;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Confirmer le mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="clientConfirmPwd"
                                                   class="form-control"
                                                   style="border-radius:10px 0 0 10px;"
                                                   placeholder="Répéter le mot de passe" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                    onclick="toggleClientPwd('clientConfirmPwd', this)"
                                                    style="border-radius:0 10px 10px 0;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-warning fw-semibold"
                                                style="border-radius:10px; padding:0.7rem 1.5rem; color:#fff;">
                                            <i class="bi bi-lock me-1"></i> Changer le mot de passe
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

{{-- ════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    /* ═══════════════════════════════════════════════════════
       1. INITIALISATION AOS (animations au scroll)
    ═══════════════════════════════════════════════════════ */
    AOS.init({ duration: 700, once: true, offset: 40 });

    /* ═══════════════════════════════════════════════════════
       2. NAVIGATION ENTRE SECTIONS
       Masque toutes les sections puis affiche celle demandée
       Met à jour le lien actif dans la sidebar
    ═══════════════════════════════════════════════════════ */
    function showSection(sectionId, linkEl) {
        document.querySelectorAll('.client-section').forEach(el => el.classList.add('d-none'));
        const target = document.getElementById('section-' + sectionId);
        if (target) target.classList.remove('d-none');
        document.querySelectorAll('.sidebar-nav-link').forEach(l => l.classList.remove('active'));
        if (linkEl) linkEl.classList.add('active');
        closeSidebar();
    }

    /* ═══════════════════════════════════════════════════════
       3. SIDEBAR MOBILE — Ouverture et fermeture
    ═══════════════════════════════════════════════════════ */
    function closeSidebar() {
        document.getElementById('clientSidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('active');
    }

    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('clientSidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    });

    document.getElementById('sidebarOverlay')?.addEventListener('click', closeSidebar);

    /* ═══════════════════════════════════════════════════════
       4. PREVIEW AVATAR EN TEMPS RÉEL
       Met à jour topbar + sidebar + profil dès la sélection
    ═══════════════════════════════════════════════════════ */
    function previewClientAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileAvatarPreview').src = e.target.result;
                document.getElementById('topbarAvatarClient').src   = e.target.result;
                document.getElementById('sidebarAvatarClient').src  = e.target.result;
                document.getElementById('clientAvatarSaveBtn').classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    /* ═══════════════════════════════════════════════════════
       5. TOGGLE VISIBILITÉ MOT DE PASSE
    ═══════════════════════════════════════════════════════ */
    function toggleClientPwd(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    /* ═══════════════════════════════════════════════════════
       6. OUVERTURE AUTOMATIQUE DES SECTIONS
       Redirige vers la bonne section selon les erreurs Laravel
    ═══════════════════════════════════════════════════════ */

    {{-- Ouvrir "Mes dossiers" si erreur de création de dossier --}}
    @if($errors->has('service_id'))
        document.addEventListener('DOMContentLoaded', function() {
            showSection('dossiers', document.getElementById('link-dossiers'));
        });
    @endif

    {{-- Ouvrir "Mon profil" si erreur sur les infos personnelles --}}
    @if($errors->has('name') || $errors->has('email') || session('profile_success'))
        document.addEventListener('DOMContentLoaded', function() {
            showSection('profil', document.getElementById('link-profil'));
        });
    @endif

    {{-- Ouvrir "Mon profil" + onglet mot de passe si erreur password --}}
    @if($errors->has('current_password') || $errors->has('password') || session('password_success'))
        document.addEventListener('DOMContentLoaded', function() {
            showSection('profil', document.getElementById('link-profil'));
            setTimeout(function() {
                const tab = document.getElementById('tab-pwd-client');
                if (tab) new bootstrap.Tab(tab).show();
            }, 200);
        });
    @endif
</script>

</body>
</html>