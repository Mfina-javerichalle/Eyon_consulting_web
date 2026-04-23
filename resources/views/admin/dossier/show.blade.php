<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dossier #{{ $dossier->id }} — {{ $dossier->user->name ?? '' }} — Admin Elyon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary:        #0a2463;
            --primary-light:  #1e40af;
            --primary-xlight: #dbeafe;
            --accent:         #f0a500;
            --accent-light:   #fbbf24;
            --dark:           #07152b;
            --text:           #1e293b;
            --muted:          #64748b;
            --light-bg:       #f1f5f9;
            --border:         #e2e8f0;
            --success:        #10b981;
            --danger:         #ef4444;
            --warning:        #f59e0b;
            --font-display:   'Playfair Display', serif;
            --font-body:      'DM Sans', sans-serif;
            --topbar-h:       72px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; overflow-x: hidden; }
        body { font-family: var(--font-body); color: var(--text); background: var(--light-bg); min-height: 100vh; overflow-x: hidden; }

        /* ── TOPBAR ── */
        .ec-topbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--topbar-h);
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            z-index: 1000;
            display: flex; align-items: center;
            padding: 0 1.5rem;
            justify-content: space-between;
        }
        .topbar-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .topbar-brand img { height: 42px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.10); }
        .brand-name { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); }
        .brand-sub { font-size: 0.7rem; color: var(--muted); }
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
        .topbar-btn { display: inline-flex; align-items: center; gap: 0.4rem; background: var(--primary-xlight); color: var(--primary); border: none; border-radius: 8px; padding: 0.45rem 0.9rem; font-size: 0.82rem; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s; }
        .topbar-btn:hover { background: var(--primary); color: #fff; }
        .topbar-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }

        /* ── MAIN ── */
        .main-content { padding-top: calc(var(--topbar-h) + 2rem); padding-bottom: 3rem; }

        /* ── HERO DOSSIER ── */
        .dossier-hero {
            background: linear-gradient(135deg, var(--dark) 0%, #1a3a6b 100%);
            border-radius: 22px;
            padding: 2rem 2.5rem;
            color: white;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .dossier-hero::before {
            content: "";
            position: absolute; top: -80px; right: -80px;
            width: 260px; height: 260px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .dossier-hero::after {
            content: "";
            position: absolute; bottom: -40px; left: 30%;
            width: 180px; height: 180px;
            background: rgba(240,165,0,0.06);
            border-radius: 50%;
        }
        .back-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: rgba(255,255,255,0.7); text-decoration: none;
            font-size: 0.85rem; font-weight: 600;
            transition: color 0.2s; margin-bottom: 1.25rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 0.35rem 0.85rem; border-radius: 8px;
        }
        .back-btn:hover { color: white; background: rgba(255,255,255,0.14); }
        .dossier-hero-title { font-family: var(--font-display); font-size: 1.65rem; font-weight: 800; margin-bottom: 0.4rem; }
        .dossier-hero-sub { font-size: 0.88rem; color: rgba(255,255,255,0.65); }

        /* ── ADMIN BADGE ── */
        .admin-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(240,165,0,0.18); color: var(--accent-light);
            border: 1px solid rgba(240,165,0,0.25);
            font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem;
            border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em;
        }

        /* ── BADGES STATUT ── */
        .status-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.28rem 0.8rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; }
        .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .status-en_attente { background: rgba(245,158,11,0.12); color: #92400e; }.status-en_attente::before { background: #f59e0b; }
        .status-en_cours   { background: rgba(59,130,246,0.12);  color: #1d4ed8; }.status-en_cours::before   { background: #3b82f6; }
        .status-valide     { background: rgba(16,185,129,0.12);  color: #065f46; }.status-valide::before     { background: #10b981; }
        .status-refuse     { background: rgba(239,68,68,0.12);   color: #991b1b; }.status-refuse::before     { background: #ef4444; }
        .status-badge-white { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.25); }

        /* ── META INFO ── */
        .meta-grid { display: flex; flex-wrap: wrap; gap: 1.5rem; margin-top: 1rem; }
        .meta-item { display: flex; flex-direction: column; gap: 0.1rem; }
        .meta-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.45); }
        .meta-value { font-size: 0.9rem; font-weight: 600; color: rgba(255,255,255,0.9); }

        /* ── ONGLETS ── */
        .ec-tabs { display: flex; gap: 0.25rem; background: white; border-radius: 14px; padding: 0.4rem; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(10,36,99,0.05); margin-bottom: 1.75rem; flex-wrap: wrap; }
        .ec-tab-btn {
            flex: 1; min-width: 120px;
            display: flex; align-items: center; justify-content: center; gap: 0.45rem;
            padding: 0.65rem 1rem; border-radius: 10px;
            font-size: 0.875rem; font-weight: 600;
            color: var(--muted); background: transparent; border: none; cursor: pointer;
            transition: all 0.22s; white-space: nowrap;
        }
        .ec-tab-btn:hover { background: var(--light-bg); color: var(--primary); }
        .ec-tab-btn.active { background: var(--primary); color: #fff; box-shadow: 0 4px 14px rgba(10,36,99,0.25); }
        .ec-tab-count { font-size: 0.68rem; font-weight: 700; padding: 0.1rem 0.45rem; border-radius: 999px; }
        .ec-tab-btn.active .ec-tab-count { background: rgba(255,255,255,0.2); color: #fff; }
        .ec-tab-btn:not(.active) .ec-tab-count { background: var(--light-bg); color: var(--muted); }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* ── EC CARD ── */
        .ec-card { background: white; border-radius: 18px; border: 1px solid var(--border); box-shadow: 0 4px 16px rgba(10,36,99,0.05); overflow: hidden; margin-bottom: 1.25rem; }
        .ec-card-header { padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: #fafbfd; }
        .ec-card-header h3 { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 0.5rem; }
        .ec-card-body { padding: 1.5rem; }

        /* ── ALERTES ── */
        .ec-alert { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.9rem 1.1rem; border-radius: 12px; font-size: 0.85rem; margin-bottom: 1rem; }
        .ec-alert-warning { background: rgba(245,158,11,0.08);  border: 1px solid rgba(245,158,11,0.25); color: #92400e; }
        .ec-alert-success { background: rgba(16,185,129,0.08);  border: 1px solid rgba(16,185,129,0.25); color: #065f46; }
        .ec-alert-info    { background: rgba(30,64,175,0.07);   border: 1px solid rgba(30,64,175,0.18);  color: var(--primary); }
        .ec-alert-danger  { background: rgba(239,68,68,0.07);   border: 1px solid rgba(239,68,68,0.18);  color: #991b1b; }

        /* ── STATUT FORM ── */
        .statut-form-card { background: linear-gradient(135deg, #f8fafc, white); border-radius: 14px; border: 1.5px solid var(--border); padding: 1.5rem; margin-bottom: 1.25rem; }
        .statut-guide { display: flex; flex-wrap: wrap; gap: 0.75rem; padding: 1rem; background: var(--light-bg); border-radius: 12px; margin-top: 1.25rem; }
        .statut-guide-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.78rem; color: var(--muted); }

        /* ── DOCUMENTS ── */
        .doc-item {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 1rem; padding: 1rem 1.25rem;
            border: 1.5px solid var(--border); border-radius: 14px;
            margin-bottom: 0.75rem; background: #fafbfc;
            transition: all 0.2s;
        }
        .doc-item:hover { border-color: var(--primary-xlight); background: white; box-shadow: 0 2px 12px rgba(10,36,99,0.06); }
        .doc-item.doc-valide  { border-color: rgba(16,185,129,0.3);  background: rgba(16,185,129,0.03); }
        .doc-item.doc-refuse  { border-color: rgba(239,68,68,0.3);   background: rgba(239,68,68,0.03);  }
        .doc-item.doc-missing { border-style: dashed; background: #fafbfc; opacity: 0.7; }
        .doc-icon-wrap { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.15rem; }
        .doc-icon-pending   { background: rgba(100,116,139,0.1); color: var(--muted); }
        .doc-icon-valide    { background: rgba(16,185,129,0.15);  color: var(--success); }
        .doc-icon-refuse    { background: rgba(239,68,68,0.1);    color: var(--danger); }
        .doc-icon-attente   { background: rgba(245,158,11,0.12);  color: var(--warning); }
        .doc-name { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .doc-meta { font-size: 0.75rem; color: var(--muted); margin-top: 0.15rem; }
        .doc-tag { display: inline-block; font-size: 0.68rem; padding: 0.1rem 0.45rem; border-radius: 999px; font-weight: 700; margin-left: 0.3rem; }
        .doc-tag-obligatoire { background: rgba(239,68,68,0.1); color: var(--danger); }
        .doc-tag-facultatif  { background: rgba(100,116,139,0.1); color: var(--muted); }
        .doc-status-badge { font-size: 0.7rem; font-weight: 700; padding: 0.18rem 0.6rem; border-radius: 999px; }
        .doc-status-en_attente { background: rgba(245,158,11,0.12); color: #92400e; }
        .doc-status-valide     { background: rgba(16,185,129,0.12); color: #065f46; }
        .doc-status-refuse     { background: rgba(239,68,68,0.12);  color: #991b1b; }
        .doc-comment { font-size: 0.77rem; color: var(--danger); margin-top: 0.35rem; display: flex; align-items: center; gap: 0.3rem; background: rgba(239,68,68,0.05); border-radius: 8px; padding: 0.35rem 0.6rem; }
        .doc-actions { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.6rem; }
        .btn-doc { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.28rem 0.7rem; border-radius: 7px; font-size: 0.75rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.18s; text-decoration: none; }
        .btn-doc-view    { background: var(--primary-xlight); color: var(--primary); }
        .btn-doc-view:hover { background: var(--primary); color: #fff; }
        .btn-doc-valider { background: rgba(16,185,129,0.12); color: #065f46; }
        .btn-doc-valider:hover { background: var(--success); color: #fff; }
        .btn-doc-refuser { background: rgba(245,158,11,0.12); color: #92400e; }
        .btn-doc-refuser:hover { background: var(--warning); color: #fff; }
        .btn-doc-delete  { background: rgba(239,68,68,0.1);  color: var(--danger); }
        .btn-doc-delete:hover  { background: var(--danger); color: #fff; }

        /* ── MESSAGERIE ── */
        .chat-container {
            height: 400px; overflow-y: auto;
            padding: 1.1rem; background: #f8fafc;
            border-radius: 14px; border: 1px solid var(--border);
            margin-bottom: 1rem;
            display: flex; flex-direction: column; gap: 0.8rem;
            scroll-behavior: smooth;
        }
        .chat-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: var(--muted); text-align: center; gap: 0.5rem; }
        .chat-empty i { font-size: 2.5rem; opacity: 0.25; }
        .message-bubble { display: flex; gap: 0.55rem; max-width: 82%; }
        .message-bubble.sent     { align-self: flex-end;   flex-direction: row-reverse; }
        .message-bubble.received { align-self: flex-start; }
        .bubble-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .bubble-content { display: flex; flex-direction: column; }
        .bubble-name { font-size: 0.7rem; font-weight: 700; color: var(--muted); margin-bottom: 0.22rem; }
        .message-bubble.sent .bubble-name { text-align: right; }
        .bubble-text {
            padding: 0.7rem 0.95rem; border-radius: 16px;
            font-size: 0.875rem; line-height: 1.55; word-break: break-word;
        }
        .message-bubble.sent .bubble-text {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; border-radius: 16px 4px 16px 16px;
        }
        .message-bubble.received .bubble-text {
            background: white; color: var(--text);
            border: 1px solid var(--border);
            border-radius: 4px 16px 16px 16px;
        }
        .bubble-time { font-size: 0.67rem; color: var(--muted); margin-top: 0.22rem; }
        .message-bubble.sent .bubble-time { text-align: right; }

        /* ── ZONE RÉPONSE ── */
        .reply-zone { background: white; border-radius: 14px; border: 1.5px solid var(--border); padding: 1.1rem 1.25rem; }
        .reply-zone-header { font-size: 0.78rem; font-weight: 700; color: var(--primary); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.4rem; }
        .chat-form { display: flex; gap: 0.65rem; align-items: flex-end; }
        .chat-input {
            flex: 1; border: 1.5px solid var(--border); border-radius: 12px;
            padding: 0.7rem 1rem; font-family: var(--font-body); font-size: 0.88rem;
            resize: none; min-height: 48px; max-height: 120px;
            outline: none; transition: all 0.22s; background: #fafbfc;
        }
        .chat-input:focus { border-color: var(--primary-light); background: white; box-shadow: 0 0 0 3px rgba(30,64,175,0.08); }
        .chat-send-btn {
            width: 48px; height: 48px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none; color: white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; flex-shrink: 0; font-size: 1.05rem; transition: all 0.2s;
        }
        .chat-send-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(10,36,99,0.3); }

        /* ── DANGER ZONE ── */
        .danger-zone {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 0.75rem;
            background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.2);
            border-radius: 12px; padding: 0.9rem 1.1rem; margin-top: 0.75rem;
        }
        .danger-zone-label { font-size: 0.82rem; font-weight: 600; color: #991b1b; }
        .danger-zone-sub { font-size: 0.73rem; color: #dc2626; }
        .btn-clear-msgs {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(239,68,68,0.1); color: var(--danger);
            border: 1px solid rgba(239,68,68,0.25); border-radius: 8px;
            padding: 0.4rem 0.9rem; font-size: 0.8rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-clear-msgs:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* ── RÉSUMÉ ── */
        .resume-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem; padding: 0.65rem 0; border-bottom: 1px solid #f1f5f9; }
        .resume-row:last-child { border-bottom: none; padding-bottom: 0; }
        .resume-label { color: var(--muted); }
        .resume-value { font-weight: 600; }

        /* ── MODAL ── */
        .modal-content { border-radius: 18px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.18); overflow: hidden; }
        .modal-header { padding: 1.1rem 1.5rem; background: var(--danger); }
        .modal-title { color: white; font-size: 1rem; font-weight: 700; }
        .modal-header .btn-close { filter: invert(1); opacity: 0.8; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
        .form-label-modal { font-size: 0.8rem; font-weight: 700; color: var(--primary); margin-bottom: 0.4rem; display: block; }
        .form-control-modal { width: 100%; padding: 0.65rem 1rem; border: 1.5px solid var(--border); border-radius: 10px; font-family: var(--font-body); font-size: 0.875rem; outline: none; resize: vertical; min-height: 90px; transition: border-color 0.2s; }
        .form-control-modal:focus { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,0.08); }
        .btn-modal-cancel { background: transparent; border: 1.5px solid var(--border); color: var(--muted); border-radius: 10px; padding: 0.55rem 1.1rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-modal-cancel:hover { background: var(--light-bg); }
        .btn-modal-confirm { background: var(--danger); color: white; border: none; border-radius: 10px; padding: 0.55rem 1.25rem; font-size: 0.875rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s; }
        .btn-modal-confirm:hover { background: #b91c1c; }

        /* ── INLINE FORM ── */
        .inline-form { display: inline; }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            .dossier-hero { padding: 1.5rem; }
            .dossier-hero-title { font-size: 1.35rem; }
            .meta-grid { gap: 1rem; }
            .doc-item { flex-direction: column; }
            .message-bubble { max-width: 92%; }
            .ec-tabs { gap: 0.15rem; }
            .ec-tab-btn { font-size: 0.8rem; padding: 0.55rem 0.75rem; min-width: 0; }
        }
    </style>
</head>
<body>

{{-- ════ TOPBAR ════ --}}
<header class="ec-topbar">
    <a class="topbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Elyon">
        <div>
            <div class="brand-name">Elyon Consulting</div>
            <div class="brand-sub">Administration</div>
        </div>
    </a>
    <div class="topbar-right">
        <a href="{{ route('admin.dashboard') }}" class="topbar-btn">
            <i class="bi bi-grid-1x2"></i>
            <span class="d-none d-md-inline">Dashboard</span>
        </a>
        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/avatar.png') }}"
             class="topbar-avatar" alt="Avatar">
    </div>
</header>

{{-- ════ MAIN ════ --}}
<div class="main-content">
    <div class="container">

        {{-- Flash --}}
        @if(session('success'))
            <div class="ec-alert ec-alert-success mb-3" data-aos="fade-down">
                <i class="bi bi-check-circle-fill" style="flex-shrink:0;font-size:1rem;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="ec-alert ec-alert-danger mb-3" data-aos="fade-down">
                <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;font-size:1rem;"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ════ HERO ════ --}}
        <div class="dossier-hero" data-aos="fade-up">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i> Retour aux dossiers
            </a>
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="admin-badge"><i class="bi bi-shield-fill-check"></i> Admin</span>
                    </div>
                    <h1 class="dossier-hero-title">
                        Dossier #{{ $dossier->id }} — {{ $dossier->service->nom ?? '—' }}
                    </h1>
                    <p class="dossier-hero-sub mb-0">
                        <i class="bi bi-person me-1"></i> {{ $dossier->user->name ?? '—' }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-geo-alt me-1"></i> {{ $dossier->service->pays ?? '—' }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-calendar3 me-1"></i> {{ $dossier->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
                <span class="status-badge status-badge-white mt-1">
                    <i class="bi bi-circle-fill" style="font-size:0.42rem;"></i>
                    {{ ucfirst(str_replace('_', ' ', $dossier->statut)) }}
                </span>
            </div>
            <div class="meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Email client</span>
                    <span class="meta-value">{{ $dossier->user->email ?? '—' }}</span>
                </div>
                @if($dossier->user->telephone)
                <div class="meta-item">
                    <span class="meta-label">Téléphone</span>
                    <span class="meta-value">{{ $dossier->user->telephone }}</span>
                </div>
                @endif
                <div class="meta-item">
                    <span class="meta-label">Documents</span>
                    <span class="meta-value">{{ $dossier->documents->count() }} / {{ $documentsAvecStatut->count() }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Messages</span>
                    <span class="meta-value">{{ $messages->count() }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Dernière MAJ</span>
                    <span class="meta-value">{{ $dossier->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{-- ════ ONGLETS ════ --}}
        <div class="ec-tabs" data-aos="fade-up">
            <button class="ec-tab-btn active" id="btn-tab-statut" onclick="showTab('statut', this)">
                <i class="bi bi-gear-fill"></i> Statut
            </button>
            <button class="ec-tab-btn" id="btn-tab-documents" onclick="showTab('documents', this)">
                <i class="bi bi-file-earmark-arrow-up"></i> Documents
                <span class="ec-tab-count">{{ $dossier->documents->count() }}</span>
            </button>
            <button class="ec-tab-btn" id="btn-tab-messages" onclick="showTab('messages', this)">
                <i class="bi bi-chat-dots-fill"></i> Messagerie
                <span class="ec-tab-count">{{ $messages->count() }}</span>
            </button>
        </div>

        {{-- ════ ONGLET 1 — STATUT ════ --}}
        <div class="tab-pane active" id="pane-statut" data-aos="fade-up">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="ec-card">
                        <div class="ec-card-header">
                            <h3><i class="bi bi-gear-fill"></i> Modifier le statut</h3>
                        </div>
                        <div class="ec-card-body">
                            <div class="statut-form-card">
                                <form method="POST" action="{{ route('admin.dossiers.statut', $dossier->id) }}">
                                    @csrf
                                    <label style="font-size:.8rem;font-weight:700;color:var(--primary);display:block;margin-bottom:.6rem;">
                                        Statut du dossier *
                                    </label>
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-7">
                                            <select name="statut" class="form-select" style="border-radius:10px;border:1.5px solid var(--border);font-family:var(--font-body);padding:.65rem 1rem;" required>
                                                <option value="en_attente" {{ $dossier->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="en_cours"   {{ $dossier->statut === 'en_cours'   ? 'selected' : '' }}>En cours de traitement</option>
                                                <option value="valide"     {{ $dossier->statut === 'valide'     ? 'selected' : '' }}>Validé</option>
                                                <option value="refuse"     {{ $dossier->statut === 'refuse'     ? 'selected' : '' }}>Refusé</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn w-100"
                                                    style="background:linear-gradient(135deg,var(--primary),var(--primary-light));color:#fff;border-radius:10px;font-weight:700;padding:.65rem 1rem;">
                                                <i class="bi bi-check-lg me-1"></i> Mettre à jour
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="statut-guide">
                                <div class="statut-guide-item"><span class="status-badge status-en_attente" style="font-size:.7rem;">En attente</span> Dossier créé, pas encore traité</div>
                                <div class="statut-guide-item"><span class="status-badge status-en_cours" style="font-size:.7rem;">En cours</span> Traitement en cours</div>
                                <div class="statut-guide-item"><span class="status-badge status-valide" style="font-size:.7rem;">Validé</span> Visa accordé</div>
                                <div class="statut-guide-item"><span class="status-badge status-refuse" style="font-size:.7rem;">Refusé</span> Dossier rejeté</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="ec-card">
                        <div class="ec-card-header"><h3><i class="bi bi-info-circle"></i> Résumé</h3></div>
                        <div class="ec-card-body">
                            <div class="resume-row"><span class="resume-label">Service</span><span class="resume-value">{{ $dossier->service->nom ?? '—' }}</span></div>
                            <div class="resume-row"><span class="resume-label">Destination</span><span class="resume-value">{{ $dossier->service->pays ?? '—' }}</span></div>
                            <div class="resume-row"><span class="resume-label">Client</span><span class="resume-value">{{ $dossier->user->name ?? '—' }}</span></div>
                            <div class="resume-row"><span class="resume-label">Email</span><span class="resume-value" style="font-size:.82rem;">{{ $dossier->user->email ?? '—' }}</span></div>
                            <div class="resume-row">
                                <span class="resume-label">Documents</span>
                                <span class="resume-value">{{ $documentsAvecStatut->filter(fn($d) => $d['uploaded'])->count() }} / {{ $documentsAvecStatut->count() }}</span>
                            </div>
                            <div class="resume-row">
                                <span class="resume-label">Statut actuel</span>
                                <span class="status-badge status-{{ $dossier->statut }}" style="font-size:.72rem;">{{ ucfirst(str_replace('_',' ',$dossier->statut)) }}</span>
                            </div>
                            <div class="resume-row"><span class="resume-label">Créé le</span><span class="resume-value" style="font-size:.82rem;">{{ $dossier->created_at->format('d/m/Y') }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ ONGLET 2 — DOCUMENTS ════ --}}
        <div class="tab-pane" id="pane-documents">
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-file-earmark-text"></i> Documents du dossier</h3>
                    <span style="font-size:.82rem;color:var(--muted);">
                        {{ $documentsAvecStatut->filter(fn($d) => $d['uploaded'])->count() }}
                        / {{ $documentsAvecStatut->count() }} fourni(s)
                    </span>
                </div>
                <div class="ec-card-body">

                    <div class="ec-alert ec-alert-info mb-4">
                        <i class="bi bi-info-circle-fill" style="flex-shrink:0;"></i>
                        <div>Validez, refusez (avec raison) ou supprimez les documents uploadés par le client.</div>
                    </div>

                    @forelse($documentsAvecStatut as $item)
                        @php
                            $requis   = $item['requis'];
                            $uploaded = $item['uploaded'];
                            $ext      = $uploaded ? strtolower(pathinfo($uploaded->fichier ?? '', PATHINFO_EXTENSION)) : '';
                            $isImg    = in_array($ext, ['jpg','jpeg','png','webp']);
                            $isPdf    = $ext === 'pdf';
                            $iconClass = $uploaded
                                ? ($uploaded->statut === 'valide'  ? 'doc-icon-valide'
                                : ($uploaded->statut === 'refuse'  ? 'doc-icon-refuse'  : 'doc-icon-attente'))
                                : 'doc-icon-pending';
                            $iconBi   = $uploaded
                                ? ($uploaded->statut === 'valide'  ? 'bi-check-circle-fill'
                                : ($uploaded->statut === 'refuse'  ? 'bi-x-circle-fill'
                                : ($isImg ? 'bi-file-image' : ($isPdf ? 'bi-file-pdf' : 'bi-file-earmark-arrow-up'))))
                                : 'bi-file-earmark';
                        @endphp

                        <div class="doc-item {{ $uploaded ? 'doc-'.$uploaded->statut : 'doc-missing' }}">
                            <div class="d-flex align-items-start gap-3 flex-1">
                                <div class="doc-icon-wrap {{ $iconClass }}">
                                    <i class="bi {{ $iconBi }}"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div class="doc-name">
                                        {{ $requis->nom }}
                                        @if($requis->obligatoire)
                                            <span class="doc-tag doc-tag-obligatoire">obligatoire</span>
                                        @else
                                            <span class="doc-tag doc-tag-facultatif">facultatif</span>
                                        @endif
                                    </div>

                                    @if($uploaded)
                                        <div class="doc-meta d-flex align-items-center gap-2 mt-1 flex-wrap">
                                            <span class="doc-status-badge doc-status-{{ $uploaded->statut }}">
                                                {{ ucfirst($uploaded->statut) }}
                                            </span>
                                            <span>Uploadé le {{ optional($uploaded->created_at)->format('d/m/Y à H:i') }}</span>
                                        </div>
                                        @if($uploaded->commentaire)
                                            <div class="doc-comment">
                                                <i class="bi bi-exclamation-circle"></i>
                                                <span>{{ $uploaded->commentaire }}</span>
                                            </div>
                                        @endif
                                        <div class="doc-actions">
                                            {{-- Voir --}}
                                            <a href="{{ asset('storage/'.$uploaded->fichier) }}" target="_blank" class="btn-doc btn-doc-view">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                            {{-- Valider --}}
                                            @if($uploaded->statut !== 'valide')
                                                <form method="POST" action="{{ route('admin.documents.valider', $uploaded->id) }}" class="inline-form"
                                                      onsubmit="return confirm('Valider ce document ?')">
                                                    @csrf
                                                    <button type="submit" class="btn-doc btn-doc-valider">
                                                        <i class="bi bi-check-lg"></i> Valider
                                                    </button>
                                                </form>
                                            @else
                                                <span style="font-size:.75rem;color:var(--success);font-weight:700;">
                                                    <i class="bi bi-shield-check me-1"></i>Validé
                                                </span>
                                            @endif
                                            {{-- Refuser --}}
                                            @if($uploaded->statut !== 'valide')
                                                <button type="button" class="btn-doc btn-doc-refuser"
                                                        onclick="ouvrirModalRefus('{{ route('admin.documents.refuser', $uploaded->id) }}', '{{ addslashes($requis->nom) }}')">
                                                    <i class="bi bi-x-lg"></i> Refuser
                                                </button>
                                            @endif
                                            {{-- Supprimer --}}
                                            <form method="POST" action="{{ route('admin.documents.supprimer', $uploaded->id) }}" class="inline-form"
                                                  onsubmit="return confirm('Supprimer définitivement ce document ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-doc btn-doc-delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="doc-meta mt-1">
                                            <i class="bi bi-hourglass me-1"></i> En attente d'upload par le client
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5" style="color:var(--muted);">
                            <i class="bi bi-folder2-open" style="font-size:2.5rem;display:block;margin-bottom:.75rem;opacity:.25;"></i>
                            <p>Aucun document requis configuré pour ce service.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- ════ ONGLET 3 — MESSAGERIE ════ --}}
        <div class="tab-pane" id="pane-messages">
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-chat-dots-fill"></i> Conversation avec {{ $dossier->user->name ?? 'le client' }}</h3>
                    <span style="font-size:.82rem;color:var(--muted);">{{ $messages->count() }} message(s)</span>
                </div>
                <div class="ec-card-body">

                    {{-- Fil de messages --}}
                    <div class="chat-container" id="chatContainer">
                        @if($messages->isEmpty())
                            <div class="chat-empty">
                                <i class="bi bi-chat-square-dots"></i>
                                <p style="font-size:.88rem;">Aucun message pour ce dossier.</p>
                                <p style="font-size:.78rem;">Envoyez un premier message au client.</p>
                            </div>
                        @else
                            @foreach($messages as $message)
                                @php
                                    $isAdmin = ($message->expediteur->role ?? 'client') === 'admin';
                                    $avatarSrc = $message->expediteur->avatar
                                        ? asset('storage/'.$message->expediteur->avatar)
                                        : asset('images/avatar.png');
                                @endphp
                                <div class="message-bubble {{ $isAdmin ? 'sent' : 'received' }}">
                                    <img src="{{ $avatarSrc }}" class="bubble-avatar" alt="Avatar">
                                    <div class="bubble-content">
                                        <div class="bubble-name">
                                            {{ $isAdmin ? 'Vous (Admin)' : $message->expediteur->name ?? '—' }}
                                        </div>
                                        <div class="bubble-text">{{ $message->contenu }}</div>
<span class="msg-time" data-utc="{{ optional($message->created_at)->toISOString() }}">
    {{ optional($message->created_at)->format('d/m/Y à H:i') }}
</span>                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- Zone de réponse --}}
                    <div class="reply-zone">
                        <div class="reply-zone-header">
                            <i class="bi bi-reply-fill text-primary"></i> Répondre au client
                        </div>
                        <form method="POST" action="{{ route('admin.dossiers.messages.store', $dossier->id) }}">
                            @csrf
                            @error('contenu')
                                <div class="ec-alert ec-alert-danger mb-2" style="font-size:.8rem;">
                                    <i class="bi bi-exclamation-circle" style="flex-shrink:0;"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="chat-form">
                                <textarea name="contenu" class="chat-input"
                                          placeholder="Écrivez votre message au client…"
                                          rows="1" maxlength="1000"
                                          required>{{ old('contenu') }}</textarea>
                                <button type="submit" class="chat-send-btn" title="Envoyer">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                            <div style="font-size:.7rem;color:var(--muted);margin-top:.35rem;">
                                Ctrl+Entrée pour envoyer · Max 1000 caractères
                            </div>
                        </form>
                    </div>

                    {{-- Danger zone — effacer conversation --}}
                    @if($messages->isNotEmpty())
                        <div class="danger-zone">
                            <div>
                                <div class="danger-zone-label"><i class="bi bi-trash3 me-1"></i> Effacer toute la conversation</div>
                                <div class="danger-zone-sub">Cette action supprime définitivement tous les messages de ce dossier.</div>
                            </div>
                            <form method="POST" action="{{ route('admin.dossiers.messages.clear', $dossier->id) }}"
                                  onsubmit="return confirm('Effacer toute la conversation ? Cette action est irréversible.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-clear-msgs">
                                    <i class="bi bi-trash3-fill"></i> Effacer
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

{{-- ════ MODAL REFUS DOCUMENT ════ --}}
<div class="modal fade" id="modalRefusDoc" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Refuser le document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formRefusDoc" action="">
                @csrf
                <div class="modal-body">
                    <div id="refusDocNomDisplay" class="mb-3 p-3 rounded-3"
                         style="background:var(--light-bg);border:1px solid var(--border);font-size:.875rem;font-weight:600;color:var(--primary);">
                    </div>
                    <div class="ec-alert ec-alert-warning mb-3" style="font-size:.82rem;">
                        <i class="bi bi-info-circle" style="flex-shrink:0;"></i>
                        Le client verra cette raison et pourra corriger puis re-soumettre.
                    </div>
                    <label class="form-label-modal">Raison du refus *</label>
                    <textarea name="commentaire" class="form-control-modal"
                              placeholder="Ex: Document illisible, passeport expiré, mauvaise qualité…"
                              maxlength="500" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-modal-confirm">
                        <i class="bi bi-x-circle"></i> Confirmer le refus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 700, once: true, offset: 40 });

/* ── Navigation onglets ── */
function showTab(id, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.ec-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('pane-' + id)?.classList.add('active');
    btn.classList.add('active');
    if (id === 'messages') scrollChat();
}

/* ── Scroll chat vers le bas ── */
function scrollChat() {
    const c = document.getElementById('chatContainer');
    if (c) requestAnimationFrame(() => { c.scrollTop = c.scrollHeight; });
}

/* ══════════════════════════════════════════════
   CONVERSION DES DATES UTC → HEURE LOCALE
   But : corriger le décalage horaire entre
   la BDD (UTC) et l'utilisateur (son pays)
══════════════════════════════════════════════ */
function convertirDates() {

    // Sélectionne tous les éléments HTML qui ont
    // la classe "msg-time" dans la page
    // (= tous les divs qui affichent une heure de message)
    document.querySelectorAll('.msg-time').forEach(el => {

        // Lit l'attribut data-utc de l'élément
        // Exemple de valeur : "2026-04-23T09:00:00.000000Z"
        // C'est la date stockée en UTC dans MySQL
        const utc = el.getAttribute('data-utc');

        // Sécurité : si l'attribut est vide ou absent,
        // on arrête là pour éviter une erreur JavaScript
        if (!utc) return;

        // Crée un objet Date JavaScript à partir de la
        // chaîne UTC — JS comprend automatiquement
        // que le "Z" à la fin signifie UTC
        const date = new Date(utc);

        // Remplace le texte affiché dans le div
        // par la date convertie dans le fuseau
        // horaire LOCAL du navigateur de l'utilisateur
        // 'fr-FR' = format français (jour/mois/année)
        el.textContent = date.toLocaleString('fr-FR', {
            day:    '2-digit', // ex: 23
            month:  '2-digit', // ex: 04
            year:   'numeric', // ex: 2026
            hour:   '2-digit', // ex: 10
            minute: '2-digit'  // ex: 00
            // Résultat final : "23/04/2026, 10:00"
        });
    });
}

/* ══════════════════════════════════════════════
   ATTENDRE QUE LA PAGE SOIT ENTIÈREMENT CHARGÉE
   avant d'exécuter les fonctions
   (sinon JS cherche des éléments qui n'existent
   pas encore et ça provoque des erreurs)
══════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {

    // Scroll automatique vers le bas du chat
    // pour voir le dernier message
    scrollChat();

    // Conversion de toutes les dates UTC
    // en heure locale de l'utilisateur
    convertirDates();
});

/* ── Auto-resize textarea ── */
const chatInput = document.querySelector('.chat-input');
if (chatInput) {
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    chatInput.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
}

/* ── Modal refus document ── */
function ouvrirModalRefus(url, nomDoc) {
    document.getElementById('formRefusDoc').action = url;
    document.getElementById('refusDocNomDisplay').textContent = '📄 ' + nomDoc;
    document.getElementById('formRefusDoc').querySelector('textarea').value = '';
    new bootstrap.Modal(document.getElementById('modalRefusDoc')).show();
}

/* ── Ouvrir onglet selon URL hash ── */
const hash = window.location.hash;
if (hash === '#documents') showTab('documents', document.getElementById('btn-tab-documents'));
if (hash === '#messages')  showTab('messages',  document.getElementById('btn-tab-messages'));

/* ── Ouvrir onglet messages si flash success après envoi message ── */
@if(session('success') && str_contains(session('success', ''), 'essage'))
    document.addEventListener('DOMContentLoaded', () => {
        showTab('messages', document.getElementById('btn-tab-messages'));
    });
@endif
</script>

</body>
</html>