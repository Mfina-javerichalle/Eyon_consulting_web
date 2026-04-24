<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration — Elyon Consulting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary:#0a2463;--primary-light:#1e40af;--primary-xlight:#dbeafe;
            --accent:#f0a500;--accent-light:#fbbf24;--dark:#07152b;
            --success:#059669;--warning:#d97706;--danger:#dc2626;--info:#0891b2;
            --muted:#64748b;--border:#e2e8f0;--bg-soft:#f8fafc;
            --sidebar-w:260px;--topbar-h:64px;--radius:12px;
            --shadow-sm:0 2px 8px rgba(10,36,99,.08);
            --shadow-md:0 4px 20px rgba(10,36,99,.12);
            --shadow-lg:0 8px 40px rgba(10,36,99,.16);
            --font-display:'Playfair Display',Georgia,serif;
            --font-body:'DM Sans',system-ui,sans-serif;
            --transition:.25s ease;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{font-family:var(--font-body);background:var(--bg-soft);color:#1e293b;min-height:100vh;overflow-x:hidden}

        /* ── SIDEBAR ── */
        .admin-sidebar{position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;background:var(--dark);display:flex;flex-direction:column;z-index:1040;overflow-y:auto;transition:transform var(--transition)}
        .sidebar-logo{padding:1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.07);flex-shrink:0}
        .sidebar-logo .brand{font-family:var(--font-display);font-size:1.35rem;font-weight:700;color:#fff;text-decoration:none;display:flex;align-items:center;gap:.6rem}
        .sidebar-logo .brand-icon{width:36px;height:36px;background:linear-gradient(135deg,var(--accent),var(--accent-light));border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;color:var(--dark);font-weight:700;flex-shrink:0}
        .sidebar-logo small{display:block;font-size:.65rem;color:rgba(255,255,255,.4);letter-spacing:2px;text-transform:uppercase;margin-top:2px}
        .sidebar-nav{padding:1rem 0;flex:1}
        .sidebar-section-title{font-size:.6rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.28);padding:.75rem 1.25rem .35rem}
        .sidebar-nav .nav-item{padding:.1rem .75rem}
        .sidebar-nav .nav-link{display:flex;align-items:center;gap:.75rem;padding:.65rem .75rem;border-radius:8px;color:rgba(255,255,255,.62);font-size:.875rem;font-weight:500;transition:all var(--transition);position:relative;cursor:pointer;text-decoration:none}
        .sidebar-nav .nav-link i{font-size:1rem;flex-shrink:0}
        .sidebar-nav .nav-link:hover,.sidebar-nav .nav-link.active{background:rgba(255,255,255,.07);color:#fff}
        .sidebar-nav .nav-link.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:60%;background:var(--accent);border-radius:0 3px 3px 0}
        .sidebar-nav .badge-count{margin-left:auto;background:var(--accent);color:var(--dark);font-size:.65rem;font-weight:700;padding:.15rem .45rem;border-radius:20px;min-width:20px;text-align:center}

        /* ── NOUVEAU : badge rouge messages non lus dans la sidebar ── */
        .badge-notif{
            margin-left:auto;
            background:var(--danger);
            color:#fff;
            font-size:.65rem;
            font-weight:700;
            padding:.15rem .45rem;
            border-radius:20px;
            min-width:20px;
            text-align:center;
        }

        .sidebar-footer{padding:1rem 1.25rem;border-top:1px solid rgba(255,255,255,.07)}
        .sidebar-footer .admin-meta{display:flex;align-items:center;gap:.75rem}
        .sidebar-footer .avatar-sm{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--primary-light),var(--primary));display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:700;flex-shrink:0;overflow:hidden}
        .sidebar-footer .avatar-sm img{width:100%;height:100%;object-fit:cover}
        .sidebar-footer .admin-info{flex:1;min-width:0}
        .sidebar-footer .admin-name{font-size:.8rem;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .sidebar-footer .admin-role{font-size:.65rem;color:rgba(255,255,255,.38)}

        /* ── TOPBAR ── */
        .admin-topbar{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--topbar-h);background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 1.5rem;gap:1rem;z-index:1030;box-shadow:var(--shadow-sm)}
        .topbar-title{font-size:1rem;font-weight:600;color:var(--primary);flex:1}
        .topbar-actions{display:flex;align-items:center;gap:.75rem}
        .topbar-icon-btn{width:38px;height:38px;border-radius:50%;border:none;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;color:var(--muted);cursor:pointer;transition:all var(--transition);position:relative;text-decoration:none}
        .topbar-icon-btn:hover{background:var(--primary-xlight);color:var(--primary)}
        .notif-dot{position:absolute;top:6px;right:6px;width:8px;height:8px;background:var(--danger);border-radius:50%;border:2px solid #fff}
        .profile-trigger{cursor:pointer;border-radius:18px;background:rgba(255,255,255,.75);backdrop-filter:blur(14px);border:1px solid rgba(255,255,255,.45);box-shadow:0 10px 30px rgba(0,0,0,.08);transition:all .25s ease;width:fit-content}
        .profile-trigger:hover{transform:translateY(-2px)}
        .profile-trigger-avatar{width:44px;height:44px;border-radius:50%;padding:2px;background:linear-gradient(135deg,#0d6efd,#6f42c1);flex-shrink:0}
        .profile-trigger-avatar img{width:100%;height:100%;object-fit:cover;border:2px solid #fff;border-radius:50%}
        .profile-trigger-label{font-weight:700;color:#1f2937;line-height:1.1}
        .profile-trigger-sub{color:#6b7280;font-size:.82rem}

        /* ── MAIN ── */
        .admin-main{margin-left:var(--sidebar-w);margin-top:var(--topbar-h);padding:1.75rem;min-height:calc(100vh - var(--topbar-h))}
        .admin-panel{display:none}
        .admin-panel.active{display:block}

        /* ── STAT CARDS ── */
        .stat-card{background:#fff;border-radius:var(--radius);padding:1.25rem 1.5rem;box-shadow:var(--shadow-sm);border:1px solid var(--border);display:flex;align-items:center;gap:1rem;transition:box-shadow var(--transition)}
        .stat-card:hover{box-shadow:var(--shadow-md)}
        .stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
        .stat-icon.blue{background:var(--primary-xlight);color:var(--primary)}
        .stat-icon.gold{background:#fef3c7;color:var(--accent)}
        .stat-icon.green{background:#d1fae5;color:var(--success)}
        .stat-icon.red{background:#fee2e2;color:var(--danger)}
        .stat-icon.cyan{background:#cffafe;color:var(--info)}
        .stat-icon.purple{background:#ede9fe;color:#7c3aed}
        .stat-value{font-size:1.75rem;font-weight:700;color:var(--primary);line-height:1}
        .stat-label{font-size:.78rem;color:var(--muted);margin-top:2px}

        /* ── PANEL CARD ── */
        .panel-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--border);overflow:hidden}
        .panel-card-header{padding:1rem 1.5rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.75rem}
        .panel-card-title{font-size:.95rem;font-weight:600;color:var(--primary);flex:1}
        .panel-card-body{padding:1.25rem 1.5rem}

        /* ── TABLES ── */
        .admin-table{width:100%;border-collapse:collapse;font-size:.84rem}
        .admin-table thead th{background:var(--bg-soft);color:var(--muted);font-weight:600;font-size:.72rem;letter-spacing:.5px;text-transform:uppercase;padding:.75rem 1rem;border-bottom:1px solid var(--border);white-space:nowrap}
        .admin-table tbody tr{border-bottom:1px solid var(--border);transition:background var(--transition)}
        .admin-table tbody tr:hover{background:#f8faff}
        .admin-table td{padding:.75rem 1rem;vertical-align:middle}
        .admin-table td:last-child{text-align:right}

        /* ── BADGES ── */
        .badge-status{display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:20px;font-size:.72rem;font-weight:600;white-space:nowrap}
        .badge-status::before{content:'';width:6px;height:6px;border-radius:50%;display:inline-block}
        .badge-en_attente{background:#fef3c7;color:#92400e}.badge-en_attente::before{background:#f59e0b}
        .badge-en_cours{background:var(--primary-xlight);color:var(--primary)}.badge-en_cours::before{background:var(--primary)}
        .badge-valide{background:#d1fae5;color:#065f46}.badge-valide::before{background:var(--success)}
        .badge-refuse{background:#fee2e2;color:#991b1b}.badge-refuse::before{background:var(--danger)}

        /* ── BOUTONS ── */
        .btn-primary-elyon{background:var(--primary);color:#fff;border:none;border-radius:8px;padding:.5rem 1.1rem;font-size:.84rem;font-weight:500;display:inline-flex;align-items:center;gap:.4rem;transition:all var(--transition);cursor:pointer;text-decoration:none}
        .btn-primary-elyon:hover{background:var(--primary-light);color:#fff}
        .btn-accent-elyon{background:var(--accent);color:var(--dark);border:none;border-radius:8px;padding:.5rem 1.1rem;font-size:.84rem;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;transition:all var(--transition);cursor:pointer}
        .btn-accent-elyon:hover{background:var(--accent-light)}
        .btn-ghost{background:transparent;border:1px solid var(--border);color:var(--muted);border-radius:8px;padding:.4rem .8rem;font-size:.8rem;font-weight:500;transition:all var(--transition);cursor:pointer}
        .btn-ghost:hover{background:var(--bg-soft);color:var(--primary);border-color:var(--primary)}
        .btn-danger-sm{background:#fee2e2;color:var(--danger);border:none;border-radius:6px;padding:.3rem .65rem;font-size:.75rem;font-weight:500;cursor:pointer;transition:all var(--transition)}
        .btn-danger-sm:hover{background:var(--danger);color:#fff}
        .btn-success-sm{background:#d1fae5;color:var(--success);border:none;border-radius:6px;padding:.3rem .65rem;font-size:.75rem;font-weight:500;cursor:pointer;transition:all var(--transition)}
        .btn-success-sm:hover{background:var(--success);color:#fff}
        .btn-edit-sm{background:var(--primary-xlight);color:var(--primary);border:none;border-radius:6px;padding:.3rem .65rem;font-size:.75rem;font-weight:500;cursor:pointer;transition:all var(--transition)}
        .btn-edit-sm:hover{background:var(--primary);color:#fff}
        .btn-manage{background:var(--primary);color:#fff;border:none;border-radius:8px;padding:.35rem .8rem;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.35rem;transition:all var(--transition);text-decoration:none}
        .btn-manage:hover{background:var(--primary-light);color:#fff;transform:translateY(-1px)}

        /* ── FORM ── */
        .form-label-elyon{font-size:.8rem;font-weight:600;color:var(--primary);margin-bottom:.35rem;display:block}
        .form-control-elyon{width:100%;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-family:var(--font-body);font-size:.875rem;color:#1e293b;background:#fff;transition:border-color var(--transition),box-shadow var(--transition);outline:none}
        .form-control-elyon:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(10,36,99,.08)}
        textarea.form-control-elyon{resize:vertical;min-height:90px}
        select.form-control-elyon{appearance:none;cursor:pointer}

        /* ── SECTION HEADING ── */
        .section-heading{display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem}
        .section-heading h2{font-family:var(--font-display);font-size:1.5rem;font-weight:700;color:var(--primary);margin:0}
        .section-heading .heading-icon{width:44px;height:44px;border-radius:10px;background:var(--primary-xlight);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--primary);flex-shrink:0}

        /* ── USER CARD ── */
        .user-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:1.1rem 1.25rem;display:flex;align-items:center;gap:1rem;transition:box-shadow var(--transition)}
        .user-card:hover{box-shadow:var(--shadow-md)}
        .user-avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;font-weight:700;flex-shrink:0}
        .user-info .user-name{font-weight:600;font-size:.9rem;color:#1e293b}
        .user-info .user-email{font-size:.75rem;color:var(--muted)}

        /* ── FILTRES ── */
        .filter-bar{display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;margin-bottom:1.25rem}
        .filter-bar select,.filter-bar input{border:1.5px solid var(--border);border-radius:8px;padding:.45rem .8rem;font-family:var(--font-body);font-size:.82rem;background:#fff;color:#1e293b;outline:none;transition:border-color var(--transition)}
        .filter-bar select:focus,.filter-bar input:focus{border-color:var(--primary)}

        /* ── MODAL ── */
        .modal-content{border-radius:var(--radius);border:none;box-shadow:var(--shadow-lg)}
        .modal-header{background:var(--primary);color:#fff;border-radius:var(--radius) var(--radius) 0 0;padding:1rem 1.5rem}
        .modal-title{font-family:var(--font-display);font-size:1.1rem;color:#fff}
        .modal-header .btn-close{filter:invert(1);opacity:.7}
        .modal-body{padding:1.5rem}
        .modal-footer{padding:1rem 1.5rem;border-top:1px solid var(--border)}

        /* ── MISC ── */
        .empty-state{text-align:center;padding:3rem 1rem;color:var(--muted)}
        .empty-state i{font-size:2.5rem;opacity:.3;display:block;margin-bottom:.75rem}
        .empty-state p{font-size:.875rem}
        .alert-elyon{border-radius:10px;border:none;font-size:.84rem;padding:.9rem 1.1rem}
        .inline-form{display:inline}
        .tag-pill{display:inline-block;background:var(--bg-soft);border:1px solid var(--border);border-radius:20px;font-size:.72rem;padding:.15rem .55rem;color:var(--muted)}
        .scrollable-table{overflow-x:auto;-webkit-overflow-scrolling:touch}

        /* ── MOBILE ── */
        @media(max-width:991.98px){
            .admin-sidebar{transform:translateX(-100%)}
            .admin-sidebar.show{transform:translateX(0)}
            .admin-topbar{left:0}
            .admin-main{margin-left:0}
            .sidebar-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1035;display:none}
            .sidebar-overlay.show{display:block}
        }
        @media(max-width:576px){.admin-main{padding:1rem}.modal-dialog{margin:.5rem}}
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ════ SIDEBAR ════ --}}
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-logo">
        <a href="{{ route('home') }}" class="brand">
            <div class="brand-icon">EC</div>
            <div>Elyon Consulting<small>Administration</small></div>
        </a>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section-title">Général</div>
        <div class="nav-item">
            <span class="nav-link active" onclick="showPanel('dashboard',this)">
                <i class="bi bi-grid-1x2"></i> Tableau de bord
            </span>
        </div>
        <div class="sidebar-section-title">Dossiers</div>
        <div class="nav-item">
            <span class="nav-link" onclick="showPanel('dossiers',this)">
                <i class="bi bi-folder2-open"></i> Tous les dossiers
                @if(isset($stats['dossiers_attente']) && $stats['dossiers_attente'] > 0)
                    <span class="badge-count">{{ $stats['dossiers_attente'] }}</span>
                @endif
            </span>
        </div>

        {{-- ══════════════════════════════════════════════════════
             NOUVEAU — Lien "Messages" dans la sidebar
             Affiche un badge rouge avec le nombre de messages
             non lus si l'admin en a reçu depuis les clients
             $messagesNonLus est calculé dans AdminController@dashboard()
        ══════════════════════════════════════════════════════ --}}
        <div class="nav-item">
            <span class="nav-link" onclick="showPanel('dossiers',this)">
                <i class="bi bi-chat-dots-fill"></i> Messages
                @if(isset($messagesNonLus) && $messagesNonLus > 0)
                    {{-- Badge rouge — nombre de messages non lus --}}
                    <span class="badge-notif">{{ $messagesNonLus }}</span>
                @endif
            </span>
        </div>
        {{-- ══════════════════════════════════════════════════════ --}}

        <div class="nav-item">
            <span class="nav-link" onclick="showPanel('utilisateurs-recents',this)">
                <i class="bi bi-person-plus"></i> Nouveaux clients
            </span>
        </div>
        <div class="sidebar-section-title">Contenu</div>
        <div class="nav-item"><span class="nav-link" onclick="showPanel('services',this)"><i class="bi bi-briefcase"></i> Services</span></div>
        <div class="nav-item"><span class="nav-link" onclick="showPanel('documents',this)"><i class="bi bi-file-earmark-text"></i> Documents requis</span></div>
        <div class="nav-item"><span class="nav-link" onclick="showPanel('etapes',this)"><i class="bi bi-list-check"></i> Étapes</span></div>
        <div class="nav-item"><span class="nav-link" onclick="showPanel('infos-visa',this)"><i class="bi bi-passport"></i> Infos Visa</span></div>
        <div class="sidebar-section-title">Comptes</div>
        <div class="nav-item"><span class="nav-link" onclick="showPanel('utilisateurs',this)"><i class="bi bi-people"></i> Utilisateurs</span></div>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-meta">
            <div class="avatar-sm">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="Avatar" id="sidebarAvatarImg">
                @else
                    {{ strtoupper(substr(auth()->user()->name??'A',0,1)) }}
                @endif
            </div>
            <div class="admin-info">
                <div class="admin-name">{{ auth()->user()->name??'Administrateur' }}</div>
                <div class="admin-role">Super Admin</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline-form">
                @csrf
                <button type="submit" style="background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;padding:.25rem;" title="Déconnexion">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ════ TOPBAR ════ --}}
<header class="admin-topbar">
    <button class="d-lg-none topbar-icon-btn me-1" onclick="toggleSidebar()">
        <i class="bi bi-list" style="font-size:1.2rem;"></i>
    </button>
    <span class="topbar-title" id="topbarTitle">Tableau de bord</span>
    <div class="topbar-actions">
        <a href="{{ route('home') }}" target="_blank" class="topbar-icon-btn" title="Voir le site">
            <i class="bi bi-box-arrow-up-right"></i>
        </a>

        {{-- ══════════════════════════════════════════════════════
             NOUVEAU — Icône cloche dans la topbar
             Si l'admin a des messages non lus :
             - Un point rouge (notif-dot) apparaît sur la cloche
             - Au clic, redirige vers le panel dossiers
             pour que l'admin consulte ses messages
        ══════════════════════════════════════════════════════ --}}
        <button class="topbar-icon-btn" title="Messages non lus" onclick="showPanel('dossiers',null)">
            <i class="bi bi-chat-dots"></i>
            @if(isset($messagesNonLus) && $messagesNonLus > 0)
                {{-- Point rouge visible sur l'icône --}}
                <span class="notif-dot"></span>
            @endif
        </button>
        {{-- ══════════════════════════════════════════════════════ --}}

        <button class="topbar-icon-btn" title="Dossiers en attente" onclick="showPanel('dossiers',null)">
            <i class="bi bi-bell"></i>
            @if(isset($stats['dossiers_attente']) && $stats['dossiers_attente'] > 0)
                <span class="notif-dot"></span>
            @endif
        </button>
        <div class="profile-trigger d-flex align-items-center gap-3 px-3 py-2"
             data-bs-toggle="modal" data-bs-target="#profileModal">
            <div class="profile-trigger-avatar">
                <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/avatar.png') }}"
                     alt="Avatar" id="topbarAvatarImg">
            </div>
            <div class="d-none d-md-block text-start">
                <div class="profile-trigger-label">Mon profil</div>
                <small class="profile-trigger-sub">Voir et modifier</small>
            </div>
        </div>
    </div>
</header>

{{-- ════ MAIN ════ --}}
<main class="admin-main">

    {{-- Flash messages existants --}}
    @if(session('success'))
        <div class="alert alert-success alert-elyon alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-elyon alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         NOUVEAU — Alerte messages non lus
         S'affiche en haut dès la connexion si l'admin
         a des messages non lus envoyés par les clients.
         L'admin peut fermer l'alerte avec le bouton ×
         $messagesNonLus vient de AdminController@dashboard()
    ══════════════════════════════════════════════════════ --}}
    @if(isset($messagesNonLus) && $messagesNonLus > 0)
        <div class="alert alert-dismissible fade show mb-3" role="alert"
             style="border-radius:12px; border:none; background:#fef3c7; border-left:4px solid #f59e0b; padding:.9rem 1.1rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-bell-fill" style="color:#d97706; font-size:1.1rem; flex-shrink:0;"></i>
                <div>
                    <strong style="color:#92400e; font-size:.9rem;">
                        Vous avez {{ $messagesNonLus }} message(s) non lu(s) !
                    </strong>
                    <span style="color:#92400e; font-size:.84rem; display:block; margin-top:.1rem;">
                        Cliquez sur "Gérer" dans un dossier pour consulter et répondre aux messages des clients.
                    </span>
                </div>
            </div>
            {{-- Bouton pour fermer l'alerte --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif
    {{-- ══════════════════════════════════════════════════════ --}}

    {{-- PANEL 1 — TABLEAU DE BORD --}}
    <section class="admin-panel active" id="panel-dashboard">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-grid-1x2"></i></div>
            <h2>Vue d'ensemble</h2>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-xl-2" data-aos="fade-up" data-aos-delay="0"><div class="stat-card"><div class="stat-icon blue"><i class="bi bi-folder2-open"></i></div><div><div class="stat-value">{{ $stats['total_dossiers']??0 }}</div><div class="stat-label">Total dossiers</div></div></div></div>
            <div class="col-6 col-md-4 col-xl-2" data-aos="fade-up" data-aos-delay="60"><div class="stat-card"><div class="stat-icon gold"><i class="bi bi-hourglass-split"></i></div><div><div class="stat-value">{{ $stats['dossiers_attente']??0 }}</div><div class="stat-label">En attente</div></div></div></div>
            <div class="col-6 col-md-4 col-xl-2" data-aos="fade-up" data-aos-delay="120"><div class="stat-card"><div class="stat-icon cyan"><i class="bi bi-arrow-repeat"></i></div><div><div class="stat-value">{{ $stats['dossiers_cours']??0 }}</div><div class="stat-label">En cours</div></div></div></div>
            <div class="col-6 col-md-4 col-xl-2" data-aos="fade-up" data-aos-delay="180"><div class="stat-card"><div class="stat-icon green"><i class="bi bi-check-circle"></i></div><div><div class="stat-value">{{ $stats['dossiers_valides']??0 }}</div><div class="stat-label">Validés</div></div></div></div>
            <div class="col-6 col-md-4 col-xl-2" data-aos="fade-up" data-aos-delay="240"><div class="stat-card"><div class="stat-icon red"><i class="bi bi-x-circle"></i></div><div><div class="stat-value">{{ $stats['dossiers_refuses']??0 }}</div><div class="stat-label">Refusés</div></div></div></div>

            {{-- ══════════════════════════════════════════════════════
                 NOUVEAU — Carte stat messages non lus
                 S'affiche uniquement s'il y a des messages non lus
                 Visible directement dans les statistiques du dashboard
            ══════════════════════════════════════════════════════ --}}
            <div class="col-6 col-md-4 col-xl-2" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card" style="@if(isset($messagesNonLus) && $messagesNonLus > 0) border-color:#fca5a5; @endif">
                    <div class="stat-icon" style="background:#fee2e2;color:var(--danger);">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div>
                        <div class="stat-value" style="@if(isset($messagesNonLus) && $messagesNonLus > 0) color:var(--danger); @endif">
                            {{ $messagesNonLus ?? 0 }}
                        </div>
                        <div class="stat-label">Non lus</div>
                    </div>
                </div>
            </div>
            {{-- ══════════════════════════════════════════════════════ --}}

        </div>
        <div class="row g-3">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="panel-card">
                    <div class="panel-card-header">
                        <i class="bi bi-clock-history text-primary me-1"></i>
                        <span class="panel-card-title">Derniers dossiers créés</span>
                        <button class="btn-ghost ms-auto" onclick="showPanel('dossiers',null)">Voir tout <i class="bi bi-arrow-right"></i></button>
                    </div>
                    <div class="scrollable-table">
                        <table class="admin-table">
                            <thead><tr><th>#ID</th><th>Client</th><th>Service</th><th>Statut</th><th>Date</th><th></th></tr></thead>
                            <tbody>
                                @forelse($dossiers->take(5) as $d)
                                    <tr>
                                        <td><span class="tag-pill">{{ $d->id }}</span></td>
                                        <td style="font-weight:500;">{{ $d->user->name??'—' }}</td>
                                        <td>{{ $d->service->nom??'—' }}</td>
                                        <td><span class="badge-status badge-{{ $d->statut }}">{{ ucfirst(str_replace('_',' ',$d->statut)) }}</span></td>
                                        <td style="color:var(--muted);font-size:.78rem;">{{ $d->created_at->format('d/m/Y') }}</td>
                                        <td><a href="{{ route('admin.dossiers.show', $d->id) }}" class="btn-manage"><i class="bi bi-eye"></i> Voir</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-inbox"></i><p>Aucun dossier.</p></div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up">
                <div class="panel-card h-100">
                    <div class="panel-card-header"><i class="bi bi-person-plus text-primary me-1"></i><span class="panel-card-title">Derniers clients</span></div>
                    <div class="panel-card-body" style="padding:.75rem;">
                        @forelse($users->where('role','client')->sortByDesc('created_at')->take(5) as $u)
                            <div class="user-card mb-2">
                                <div class="user-avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <div class="user-info"><div class="user-name">{{ $u->name }}</div><div class="user-email">{{ $u->email }}</div></div>
                                <div class="ms-auto" style="font-size:.72rem;color:var(--muted);">{{ $u->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="empty-state py-3"><i class="bi bi-people"></i><p>Aucun client.</p></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PANEL 2 — TOUS LES DOSSIERS --}}
    <section class="admin-panel" id="panel-dossiers">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-folder2-open"></i></div>
            <h2>Gestion des dossiers</h2>
        </div>
        <div class="filter-bar" data-aos="fade-up">
            <select id="filterStatut" onchange="filterDossiers()">
                <option value="">Tous les statuts</option>
                <option value="en_attente">En attente</option>
                <option value="en_cours">En cours</option>
                <option value="valide">Validé</option>
                <option value="refuse">Refusé</option>
            </select>
            <select id="filterService" onchange="filterDossiers()">
                <option value="">Tous les services</option>
                @foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }}</option>@endforeach
            </select>
            <input type="text" id="filterSearch" onkeyup="filterDossiers()" placeholder="🔍 Rechercher client...">
        </div>
        <div class="panel-card" data-aos="fade-up">
            <div class="scrollable-table">
                <table class="admin-table" id="tableDossiers">
                    <thead><tr><th>#ID</th><th>Client</th><th>Service</th><th>Docs</th><th>Messages</th><th>Statut</th><th>Créé le</th><th>Action</th></tr></thead>
                    <tbody>
                        @forelse($dossiers as $d)
                            <tr data-statut="{{ $d->statut }}" data-service="{{ $d->service_id }}" data-client="{{ strtolower($d->user->name??'') }}">
                                <td><span class="tag-pill">{{ $d->id }}</span></td>
                                <td>
                                    <div style="font-weight:600;font-size:.84rem;">{{ $d->user->name??'—' }}</div>
                                    <div style="font-size:.72rem;color:var(--muted);">{{ $d->user->email??'' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight:500;">{{ $d->service->nom??'—' }}</div>
                                    <div style="font-size:.72rem;color:var(--muted);">{{ $d->service->pays??'' }}</div>
                                </td>
                                <td>
                                    <span class="tag-pill" style="background:var(--primary-xlight);color:var(--primary);border:none;">
                                        <i class="bi bi-file-earmark me-1"></i>{{ $d->documents->count() }}
                                    </span>
                                </td>
                                <td>
                                    {{-- ══════════════════════════════════════════════════════
                                         NOUVEAU — Compteur messages avec badge non lus
                                         Si le dossier a des messages non lus pour l'admin,
                                         on affiche le nombre en rouge pour attirer l'attention
                                    ══════════════════════════════════════════════════════ --}}
                                    @php
                                        $nonLusDossier = $d->messages
                                            ->where('receiver_id', auth()->id())
                                            ->where('lu', false)
                                            ->count();
                                    @endphp
                                    <span class="tag-pill"
                                          style="background:{{ $nonLusDossier > 0 ? '#fee2e2' : '#f0fdf4' }};
                                                 color:{{ $nonLusDossier > 0 ? 'var(--danger)' : 'var(--success)' }};
                                                 border-color:{{ $nonLusDossier > 0 ? '#fca5a5' : '#bbf7d0' }};
                                                 font-weight:{{ $nonLusDossier > 0 ? '700' : '500' }};">
                                        <i class="bi bi-chat-dots me-1"></i>{{ $d->messages->count() }}
                                        @if($nonLusDossier > 0)
                                            {{-- Petit indicateur "nouveau" si messages non lus --}}
                                            <span style="font-size:.6rem; margin-left:.2rem;">● {{ $nonLusDossier }} nouveau(x)</span>
                                        @endif
                                    </span>
                                    {{-- ══════════════════════════════════════════════════════ --}}
                                </td>
                                <td><span class="badge-status badge-{{ $d->statut }}">{{ ucfirst(str_replace('_',' ',$d->statut)) }}</span></td>
                                <td style="color:var(--muted);font-size:.78rem;">{{ $d->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.dossiers.show', $d->id) }}" class="btn-manage">
                                        <i class="bi bi-gear-fill"></i> Gérer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="empty-state"><i class="bi bi-folder-x"></i><p>Aucun dossier enregistré.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PANEL 3 — NOUVEAUX CLIENTS --}}
    <section class="admin-panel" id="panel-utilisateurs-recents">
        <div class="section-heading" data-aos="fade-down"><div class="heading-icon"><i class="bi bi-person-plus"></i></div><h2>Nouveaux clients</h2></div>
        <div class="row g-3" data-aos="fade-up">
            @forelse($users->where('role','client')->sortByDesc('created_at') as $u)
                <div class="col-md-6 col-xl-4">
                    <div class="user-card">
                        <div class="user-avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                        <div class="user-info"><div class="user-name">{{ $u->name }}</div><div class="user-email">{{ $u->email }}</div></div>
                        <div class="ms-auto" style="font-size:.72rem;color:var(--muted);">{{ $u->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="panel-card"><div class="panel-card-body"><div class="empty-state"><i class="bi bi-person-x"></i><p>Aucun client.</p></div></div></div></div>
            @endforelse
        </div>
    </section>

    {{-- PANEL 4 — SERVICES --}}
    <section class="admin-panel" id="panel-services">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-briefcase"></i></div>
            <h2>Services</h2>
            <div class="ms-auto"><button class="btn-accent-elyon" data-bs-toggle="modal" data-bs-target="#modalAddService"><i class="bi bi-plus-lg"></i> Nouveau</button></div>
        </div>
        <div class="panel-card" data-aos="fade-up">
            <div class="scrollable-table">
                <table class="admin-table">
                    <thead><tr><th>#</th><th>Nom</th><th>Pays</th><th>Description</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($services as $s)
                            <tr>
                                <td><span class="tag-pill">{{ $s->id }}</span></td>
                                <td style="font-weight:600;">{{ $s->nom }}</td>
                                <td>{{ $s->pays??'—' }}</td>
                                <td style="font-size:.78rem;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $s->description??'—' }}</td>
                                <td>
                                    <button class="btn-edit-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditService"
                                        data-id="{{ $s->id }}" data-nom="{{ $s->nom }}"
                                        data-pays="{{ $s->pays }}" data-description="{{ $s->description }}"><i class="bi bi-pencil"></i></button>
                                    <form method="POST" action="{{ route('admin.services.destroy',$s->id) }}" class="inline-form" onsubmit="return confirm('Supprimer ce service ?')">
                                        @csrf @method('DELETE')<button type="submit" class="btn-danger-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><div class="empty-state"><i class="bi bi-briefcase"></i><p>Aucun service.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PANEL 5 — DOCUMENTS REQUIS --}}
    <section class="admin-panel" id="panel-documents">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-file-earmark-text"></i></div>
            <h2>Documents requis</h2>
            <div class="ms-auto"><button class="btn-accent-elyon" data-bs-toggle="modal" data-bs-target="#modalAddDocument"><i class="bi bi-plus-lg"></i> Ajouter</button></div>
        </div>
        <div class="panel-card" data-aos="fade-up">
            <div class="scrollable-table">
                <table class="admin-table">
                    <thead><tr><th>#</th><th>Nom</th><th>Service</th><th>Obligatoire</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($documents as $doc)
                            <tr>
                                <td><span class="tag-pill">{{ $doc->id }}</span></td>
                                <td style="font-weight:500;">{{ $doc->nom }}</td>
                                <td>{{ $doc->service->nom??'—' }}</td>
                                <td>@if($doc->obligatoire)<span class="badge-status badge-valide">Obligatoire</span>@else<span class="badge-status badge-en_attente">Facultatif</span>@endif</td>
                                <td>
                                    <button class="btn-edit-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditDocument"
                                        data-id="{{ $doc->id }}" data-nom="{{ $doc->nom }}"
                                        data-service="{{ $doc->service_id }}" data-obligatoire="{{ $doc->obligatoire?'1':'0' }}"><i class="bi bi-pencil"></i></button>
                                    <form method="POST" action="{{ route('admin.documents.destroy',$doc->id) }}" class="inline-form" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')<button type="submit" class="btn-danger-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><div class="empty-state"><i class="bi bi-file-earmark-x"></i><p>Aucun document configuré.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PANEL 6 — ÉTAPES --}}
    <section class="admin-panel" id="panel-etapes">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-list-check"></i></div>
            <h2>Étapes de traitement</h2>
            <div class="ms-auto"><button class="btn-accent-elyon" data-bs-toggle="modal" data-bs-target="#modalAddEtape"><i class="bi bi-plus-lg"></i> Ajouter</button></div>
        </div>
        <div class="panel-card" data-aos="fade-up">
            <div class="scrollable-table">
                <table class="admin-table">
                    <thead><tr><th>#</th><th>Titre</th><th>Service</th><th>Ordre</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($etapes as $e)
                            <tr>
                                <td><span class="tag-pill">{{ $e->id }}</span></td>
                                <td style="font-weight:500;">{{ $e->nom }}</td>
                                <td>{{ $e->service->nom??'—' }}</td>
                                <td><span class="tag-pill" style="background:var(--primary-xlight);color:var(--primary);border:none;">{{ $e->ordre }}</span></td>
                                <td>
                                    <button class="btn-edit-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditEtape"
                                        data-id="{{ $e->id }}" data-nom="{{ $e->nom }}"
                                        data-service="{{ $e->service_id }}" data-ordre="{{ $e->ordre }}"><i class="bi bi-pencil"></i></button>
                                    <form method="POST" action="{{ route('admin.etapes.destroy',$e->id) }}" class="inline-form" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')<button type="submit" class="btn-danger-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><div class="empty-state"><i class="bi bi-list-check"></i><p>Aucune étape.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PANEL 7 — INFOS VISA --}}
    <section class="admin-panel" id="panel-infos-visa">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-passport"></i></div>
            <h2>Informations Visa</h2>
            <div class="ms-auto"><button class="btn-accent-elyon" data-bs-toggle="modal" data-bs-target="#modalAddInfosVisa"><i class="bi bi-plus-lg"></i> Ajouter</button></div>
        </div>
        <div class="panel-card" data-aos="fade-up">
            <div class="scrollable-table">
                <table class="admin-table">
                    <thead><tr><th>#</th><th>Service</th><th>Délai</th><th>Frais</th><th>Ambassade</th><th>Notes</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($infosVisa as $v)
                            <tr>
                                <td><span class="tag-pill">{{ $v->id }}</span></td>
                                <td>{{ $v->service->nom??'—' }}</td>
                                <td>{{ $v->delai??'—' }}</td>
                                <td style="font-weight:600;color:var(--primary);">{{ $v->frais??'—' }}</td>
                                <td>{{ $v->ambassade??'—' }}</td>
                                <td style="font-size:.78rem;max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $v->notes??'—' }}</td>
                                <td>
                                    <button class="btn-edit-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditInfosVisa"
                                        data-id="{{ $v->id }}" data-service="{{ $v->service_id }}"
                                        data-delai="{{ $v->delai }}" data-frais="{{ $v->frais }}"
                                        data-ambassade="{{ $v->ambassade }}" data-notes="{{ $v->notes }}"><i class="bi bi-pencil"></i></button>
                                    <form method="POST" action="{{ route('admin.infosVisa.destroy',$v->id) }}" class="inline-form" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')<button type="submit" class="btn-danger-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7"><div class="empty-state"><i class="bi bi-passport"></i><p>Aucune info visa.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- PANEL 8 — UTILISATEURS --}}
    <section class="admin-panel" id="panel-utilisateurs">
        <div class="section-heading" data-aos="fade-down">
            <div class="heading-icon"><i class="bi bi-people"></i></div>
            <h2>Gestion des utilisateurs</h2>
        </div>
        <div class="panel-card" data-aos="fade-up">
            <div class="scrollable-table">
                <table class="admin-table">
                    <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Rôle</th><th>Statut</th><th>Inscrit le</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td><span class="tag-pill">{{ $u->id }}</span></td>
                                <td><div style="display:flex;align-items:center;gap:.6rem;"><div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:700;flex-shrink:0;">{{ strtoupper(substr($u->name,0,1)) }}</div><span style="font-weight:500;font-size:.84rem;">{{ $u->name }}</span></div></td>
                                <td style="font-size:.82rem;color:var(--muted);">{{ $u->email }}</td>
                                <td style="font-size:.82rem;color:var(--muted);">{{ $u->telephone??'—' }}</td>
                                <td>@if($u->role==='admin')<span class="badge-status badge-en_cours">Admin</span>@else<span class="badge-status badge-en_attente">Client</span>@endif</td>
                                <td>@if($u->actif)<span class="badge-status badge-valide">Actif</span>@else<span class="badge-status badge-refuse">Suspendu</span>@endif</td>
                                <td style="color:var(--muted);font-size:.78rem;">{{ $u->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($u->role!=='admin')
                                        <form method="POST" action="{{ route('admin.users.toggleActif',$u->id) }}" class="inline-form">@csrf @method('PATCH')
                                            <button type="submit" class="{{ $u->actif?'btn-danger-sm':'btn-success-sm' }} me-1"><i class="bi bi-{{ $u->actif?'pause-circle':'play-circle' }}"></i> {{ $u->actif?'Désactiver':'Activer' }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy',$u->id) }}" class="inline-form" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')
                                            <button type="submit" class="btn-danger-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @else
                                        <span style="font-size:.72rem;color:var(--muted);">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="empty-state"><i class="bi bi-people"></i><p>Aucun utilisateur.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>

{{-- ════ MODAL PROFIL ADMIN ════ --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius:24px;overflow:hidden;">
            <div class="modal-body p-0">
                <div class="text-center py-4 px-4" style="background:linear-gradient(135deg,#0f172a,#1e3a5f);">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/avatar.png') }}"
                             class="rounded-circle border border-3 border-white"
                             style="width:90px;height:90px;object-fit:cover;" alt="Avatar" id="avatarPreview">
                        <form action="{{ route('admin.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">@csrf
                            <label title="Changer la photo" style="position:absolute;bottom:2px;right:2px;width:28px;height:28px;border-radius:50%;background:#3b82f6;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid #fff;font-size:12px;">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" name="avatar" hidden accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewAvatar(this)">
                            </label>
                        </form>
                    </div>
                    <div class="text-white fw-bold" style="font-size:1rem;">{{ auth()->user()->name }}</div>
                    <div style="color:rgba(255,255,255,0.55);font-size:0.85rem;">{{ auth()->user()->email }}</div>
                    <span class="badge mt-2" style="background:rgba(59,130,246,0.25);color:#93c5fd;font-size:0.75rem;padding:4px 12px;border-radius:999px;border:1px solid rgba(59,130,246,0.3);">Administrateur</span>
                </div>
                <div class="px-4 pt-3 pb-1" style="background:#fff;border-bottom:1px solid #e5e7eb;">
                    <ul class="nav nav-pills gap-2">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pane-profil-admin" type="button" style="font-size:.85rem;border-radius:8px;padding:6px 14px;"><i class="bi bi-person me-1"></i> Mon profil</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-mdp-admin" data-bs-toggle="pill" data-bs-target="#pane-mdp-admin" type="button" style="font-size:.85rem;border-radius:8px;padding:6px 14px;"><i class="bi bi-lock me-1"></i> Mot de passe</button></li>
                    </ul>
                </div>
                <div class="tab-content px-4 pb-4 pt-3" style="background:#fff;">
                    <div class="tab-pane fade show active" id="pane-profil-admin">
                        <div id="avatarSaveBtn" class="d-none mb-3">
                            <button type="button" onclick="document.getElementById('avatarForm').submit();" class="btn btn-primary w-100" style="border-radius:10px;font-size:.88rem;"><i class="bi bi-floppy me-1"></i> Sauvegarder la photo</button>
                        </div>
                        <form action="{{ route('admin.profile.update') }}" method="POST">@csrf
                            <div class="mb-3"><label style="font-size:.82rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;">Nom complet</label><input type="text" name="name" value="{{ old('name',auth()->user()->name) }}" class="form-control @error('name') is-invalid @enderror" style="border-radius:10px;" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="mb-3"><label style="font-size:.82rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;">Email</label><input type="email" name="email" value="{{ old('email',auth()->user()->email) }}" class="form-control @error('email') is-invalid @enderror" style="border-radius:10px;" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="mb-3"><label style="font-size:.82rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;">Téléphone <span style="color:#9ca3af;font-size:.75rem;">(optionnel)</span></label><input type="text" name="telephone" value="{{ old('telephone',auth()->user()->telephone) }}" class="form-control" style="border-radius:10px;" placeholder="+242 06 000 00 00"></div>
                            <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;"><i class="bi bi-floppy me-1"></i> Enregistrer</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pane-mdp-admin">
                        <div class="alert mb-3 py-2" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;font-size:.82rem;color:#1e40af;"><i class="bi bi-info-circle me-1"></i> Minimum <strong>8 caractères</strong>.</div>
                        @error('current_password')<div class="alert alert-danger py-2 mb-3" style="font-size:.82rem;border-radius:10px;">{{ $message }}</div>@enderror
                        <form action="{{ route('password.change') }}" method="POST">@csrf
                            <div class="mb-3"><label style="font-size:.82rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;">Mot de passe actuel</label><div class="input-group"><input type="password" name="current_password" id="adminCurrentPwd" class="form-control" style="border-radius:10px 0 0 10px;" required><button class="btn btn-outline-secondary" type="button" onclick="togglePwd('adminCurrentPwd',this)" style="border-radius:0 10px 10px 0;"><i class="bi bi-eye"></i></button></div></div>
                            <div class="mb-3"><label style="font-size:.82rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;">Nouveau mot de passe</label><div class="input-group"><input type="password" name="password" id="adminNewPwd" class="form-control" style="border-radius:10px 0 0 10px;" required><button class="btn btn-outline-secondary" type="button" onclick="togglePwd('adminNewPwd',this)" style="border-radius:0 10px 10px 0;"><i class="bi bi-eye"></i></button></div></div>
                            <div class="mb-3"><label style="font-size:.82rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;">Confirmer</label><div class="input-group"><input type="password" name="password_confirmation" id="adminConfirmPwd" class="form-control" style="border-radius:10px 0 0 10px;" required><button class="btn btn-outline-secondary" type="button" onclick="togglePwd('adminConfirmPwd',this)" style="border-radius:0 10px 10px 0;"><i class="bi bi-eye"></i></button></div></div>
                            <button type="submit" class="btn btn-warning w-100 fw-semibold" style="border-radius:10px;color:#fff;"><i class="bi bi-lock me-1"></i> Changer le mot de passe</button>
                        </form>
                    </div>
                </div>
                <div class="px-4 pb-4" style="background:#fff;border-top:1px solid #f3f4f6;">
                    <button class="btn btn-outline-danger w-100 mt-2" style="border-radius:10px;" onclick="document.getElementById('logout-form-admin').submit();"><i class="bi bi-box-arrow-right me-1"></i> Se déconnecter</button>
                    <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ════ MODALS CRUD ════ --}}
<div class="modal fade" id="modalAddService" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-briefcase me-2"></i>Nouveau service</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" action="{{ route('admin.services.store') }}">@csrf<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Nom *</label><input type="text" name="nom" class="form-control-elyon" required placeholder="Ex: Études en France"></div><div class="mb-3"><label class="form-label-elyon">Pays *</label><input type="text" name="pays" class="form-control-elyon" required placeholder="Ex: France"></div><div class="mb-3"><label class="form-label-elyon">Description</label><textarea name="description" class="form-control-elyon" rows="3"></textarea></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-accent-elyon"><i class="bi bi-check-lg me-1"></i> Créer</button></div></form></div></div></div>
<div class="modal fade" id="modalEditService" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Modifier le service</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" id="formEditService" action="">@csrf @method('PUT')<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Nom *</label><input type="text" name="nom" id="editServiceNom" class="form-control-elyon" required></div><div class="mb-3"><label class="form-label-elyon">Pays *</label><input type="text" name="pays" id="editServicePays" class="form-control-elyon" required></div><div class="mb-3"><label class="form-label-elyon">Description</label><textarea name="description" id="editServiceDescription" class="form-control-elyon" rows="3"></textarea></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-primary-elyon"><i class="bi bi-check-lg me-1"></i> Enregistrer</button></div></form></div></div></div>
<div class="modal fade" id="modalAddDocument" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-file-earmark-plus me-2"></i>Nouveau document requis</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" action="{{ route('admin.documents.store') }}">@csrf<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Nom *</label><input type="text" name="nom" class="form-control-elyon" required placeholder="Ex: Passeport valide"></div><div class="mb-3"><label class="form-label-elyon">Service *</label><select name="service_id" class="form-control-elyon" required><option value="">— Choisir —</option>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }} — {{ $s->pays }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label-elyon d-flex align-items-center gap-2"><input type="checkbox" name="obligatoire" value="1" checked style="width:16px;height:16px;accent-color:var(--primary);"> Obligatoire</label></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-accent-elyon"><i class="bi bi-check-lg me-1"></i> Créer</button></div></form></div></div></div>
<div class="modal fade" id="modalEditDocument" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Modifier le document</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" id="formEditDocument" action="">@csrf @method('PUT')<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Nom *</label><input type="text" name="nom" id="editDocNom" class="form-control-elyon" required></div><div class="mb-3"><label class="form-label-elyon">Service *</label><select name="service_id" id="editDocService" class="form-control-elyon" required>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }} — {{ $s->pays }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label-elyon d-flex align-items-center gap-2"><input type="checkbox" id="editDocObligatoire" name="obligatoire" value="1" style="width:16px;height:16px;accent-color:var(--primary);"> Obligatoire</label></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-primary-elyon"><i class="bi bi-check-lg me-1"></i> Enregistrer</button></div></form></div></div></div>
<div class="modal fade" id="modalAddEtape" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-list-check me-2"></i>Nouvelle étape</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" action="{{ route('admin.etapes.store') }}">@csrf<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Titre *</label><input type="text" name="nom" class="form-control-elyon" required placeholder="Ex: Dépôt du dossier"></div><div class="mb-3"><label class="form-label-elyon">Service *</label><select name="service_id" class="form-control-elyon" required><option value="">— Choisir —</option>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }} — {{ $s->pays }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label-elyon">Ordre *</label><input type="number" name="ordre" class="form-control-elyon" min="1" required placeholder="1"></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-accent-elyon"><i class="bi bi-check-lg me-1"></i> Créer</button></div></form></div></div></div>
<div class="modal fade" id="modalEditEtape" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Modifier l'étape</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" id="formEditEtape" action="">@csrf @method('PUT')<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Titre *</label><input type="text" name="nom" id="editEtapeNom" class="form-control-elyon" required></div><div class="mb-3"><label class="form-label-elyon">Service *</label><select name="service_id" id="editEtapeService" class="form-control-elyon" required>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }} — {{ $s->pays }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label-elyon">Ordre *</label><input type="number" name="ordre" id="editEtapeOrdre" class="form-control-elyon" min="1" required></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-primary-elyon"><i class="bi bi-check-lg me-1"></i> Enregistrer</button></div></form></div></div></div>
<div class="modal fade" id="modalAddInfosVisa" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-passport me-2"></i>Nouvelles infos visa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" action="{{ route('admin.infosVisa.store') }}">@csrf<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Service *</label><select name="service_id" class="form-control-elyon" required><option value="">— Choisir —</option>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }} — {{ $s->pays }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label-elyon">Délai</label><input type="text" name="delai" class="form-control-elyon" placeholder="Ex: 2 à 4 semaines"></div><div class="mb-3"><label class="form-label-elyon">Frais</label><input type="text" name="frais" class="form-control-elyon" placeholder="Ex: 80€"></div><div class="mb-3"><label class="form-label-elyon">Ambassade</label><input type="text" name="ambassade" class="form-control-elyon" placeholder="Ex: Ambassade de France"></div><div class="mb-3"><label class="form-label-elyon">Notes</label><textarea name="notes" class="form-control-elyon" rows="3"></textarea></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-accent-elyon"><i class="bi bi-check-lg me-1"></i> Créer</button></div></form></div></div></div>
<div class="modal fade" id="modalEditInfosVisa" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Modifier les infos visa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><form method="POST" id="formEditInfosVisa" action="">@csrf @method('PUT')<div class="modal-body"><div class="mb-3"><label class="form-label-elyon">Service *</label><select name="service_id" id="editVisaService" class="form-control-elyon" required>@foreach($services as $s)<option value="{{ $s->id }}">{{ $s->nom }} — {{ $s->pays }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label-elyon">Délai</label><input type="text" name="delai" id="editVisaDelai" class="form-control-elyon"></div><div class="mb-3"><label class="form-label-elyon">Frais</label><input type="text" name="frais" id="editVisaFrais" class="form-control-elyon"></div><div class="mb-3"><label class="form-label-elyon">Ambassade</label><input type="text" name="ambassade" id="editVisaAmbassade" class="form-control-elyon"></div><div class="mb-3"><label class="form-label-elyon">Notes</label><textarea name="notes" id="editVisaNotes" class="form-control-elyon" rows="3"></textarea></div></div><div class="modal-footer"><button type="button" class="btn-ghost" data-bs-dismiss="modal">Annuler</button><button type="submit" class="btn-primary-elyon"><i class="bi bi-check-lg me-1"></i> Enregistrer</button></div></form></div></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration:800, once:true, offset:60, easing:'ease-out-cubic' });

const panelTitles = {
    'dashboard':'Tableau de bord','dossiers':'Gestion des dossiers',
    'utilisateurs-recents':'Nouveaux clients','services':'Services',
    'documents':'Documents requis','etapes':'Étapes','infos-visa':'Infos Visa','utilisateurs':'Utilisateurs'
};
function showPanel(id, link) {
    document.querySelectorAll('.admin-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-'+id)?.classList.add('active');
    document.querySelectorAll('.sidebar-nav .nav-link').forEach(l => l.classList.remove('active'));
    if (link) link.classList.add('active');
    document.getElementById('topbarTitle').textContent = panelTitles[id]||'Administration';
    if (window.innerWidth < 992) closeSidebar();
    AOS.refresh();
}
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('show');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
function filterDossiers() {
    const statut  = document.getElementById('filterStatut').value.toLowerCase();
    const service = document.getElementById('filterService').value;
    const search  = document.getElementById('filterSearch').value.toLowerCase();
    document.querySelectorAll('#tableDossiers tbody tr').forEach(row => {
        const ok = (!statut  || row.dataset.statut  === statut)  &&
                   (!service || row.dataset.service === service) &&
                   (!search  || (row.dataset.client||'').includes(search));
        row.style.display = ok ? '' : 'none';
    });
}
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatarPreview').src  = e.target.result;
            document.getElementById('topbarAvatarImg').src = e.target.result;
            const si = document.getElementById('sidebarAvatarImg');
            if (si) si.src = e.target.result;
            document.getElementById('avatarSaveBtn').classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('bi-eye', input.type === 'password');
    icon.classList.toggle('bi-eye-slash', input.type === 'text');
}
document.addEventListener('shown.bs.modal', function(e) {
    const btn = e.relatedTarget;
    if (!btn) return;
    if (e.target.id === 'modalEditService') {
        document.getElementById('editServiceNom').value         = btn.dataset.nom||'';
        document.getElementById('editServicePays').value        = btn.dataset.pays||'';
        document.getElementById('editServiceDescription').value = btn.dataset.description||'';
        document.getElementById('formEditService').action = '/admin/services/'+btn.dataset.id;
    }
    if (e.target.id === 'modalEditDocument') {
        document.getElementById('editDocNom').value = btn.dataset.nom||'';
        document.getElementById('editDocObligatoire').checked = btn.dataset.obligatoire=='1';
        document.querySelectorAll('#editDocService option').forEach(o => o.selected = o.value==btn.dataset.service);
        document.getElementById('formEditDocument').action = '/admin/documents/'+btn.dataset.id;
    }
    if (e.target.id === 'modalEditEtape') {
        document.getElementById('editEtapeNom').value   = btn.dataset.nom||'';
        document.getElementById('editEtapeOrdre').value = btn.dataset.ordre||'';
        document.querySelectorAll('#editEtapeService option').forEach(o => o.selected = o.value==btn.dataset.service);
        document.getElementById('formEditEtape').action = '/admin/etapes/'+btn.dataset.id;
    }
    if (e.target.id === 'modalEditInfosVisa') {
        document.getElementById('editVisaDelai').value     = btn.dataset.delai||'';
        document.getElementById('editVisaFrais').value     = btn.dataset.frais||'';
        document.getElementById('editVisaAmbassade').value = btn.dataset.ambassade||'';
        document.getElementById('editVisaNotes').value     = btn.dataset.notes||'';
        document.querySelectorAll('#editVisaService option').forEach(o => o.selected = o.value==btn.dataset.service);
        document.getElementById('formEditInfosVisa').action = '/admin/infos-visa/'+btn.dataset.id;
    }
});
@if($errors->has('current_password') || $errors->has('password'))
    document.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Modal(document.getElementById('profileModal')).show();
        setTimeout(() => new bootstrap.Tab(document.getElementById('tab-mdp-admin')).show(), 300);
    });
@endif
</script>
</body>
</html>