<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier #{{ $dossier->id }} — Elyon Consulting</title>

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
            --primary-xlight:#dbeafe;
            --accent:        #f0a500;
            --dark:          #07152b;
            --text:          #1e293b;
            --muted:         #64748b;
            --light-bg:      #f1f5f9;
            --border:        #e2e8f0;
            --success:       #10b981;
            --danger:        #ef4444;
            --warning:       #f59e0b;
            --font-display:  'Playfair Display', serif;
            --font-body:     'DM Sans', sans-serif;
            --topbar-h:      72px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-body); color: var(--text); background: var(--light-bg); min-height: 100vh; }

        /* ── TOPBAR ── */
        .ec-topbar { position: fixed; top: 0; left: 0; right: 0; height: var(--topbar-h); background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); z-index: 1000; display: flex; align-items: center; padding: 0 1.5rem; justify-content: space-between; }
        .topbar-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .topbar-brand img { height: 40px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.10); }
        .brand-name { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); }
        .brand-sub { font-size: 0.7rem; color: var(--muted); }
        .topbar-user { display: flex; align-items: center; gap: 0.75rem; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }

        /* ── CONTENU PRINCIPAL ── */
        .main-content { padding-top: calc(var(--topbar-h) + 2rem); padding-bottom: 3rem; }

        /* ── HERO DOSSIER ── */
        .dossier-hero { background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 20px; padding: 2rem; color: white; margin-bottom: 2rem; position: relative; overflow: hidden; }
        .dossier-hero::before { content: ""; position: absolute; top: -60px; right: -60px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; }
        .dossier-hero-title { font-family: var(--font-display); font-size: 1.6rem; font-weight: 800; margin-bottom: 0.5rem; }
        .dossier-hero-sub { font-size: 0.9rem; color: rgba(255,255,255,0.75); }
        .back-btn { display: inline-flex; align-items: center; gap: 0.5rem; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: color 0.2s; margin-bottom: 1.25rem; }
        .back-btn:hover { color: white; }

        /* ── BADGES STATUT ── */
        .status-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.85rem; border-radius: 999px; font-size: 0.82rem; font-weight: 700; }
        .status-en_attente { background: rgba(245,158,11,0.15); color: #92400e; }
        .status-en_cours   { background: rgba(59,130,246,0.15);  color: #1d4ed8; }
        .status-valide     { background: rgba(16,185,129,0.15);  color: #065f46; }
        .status-refuse     { background: rgba(239,68,68,0.15);   color: #991b1b; }
        .status-badge-white { background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); }

        /* ── ONGLETS ── */
        .ec-tabs { display: flex; gap: 0.25rem; background: white; border-radius: 14px; padding: 0.4rem; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(10,36,99,0.05); margin-bottom: 1.75rem; flex-wrap: wrap; }
        .ec-tab-btn { flex: 1; min-width: 110px; display: flex; align-items: center; justify-content: center; gap: 0.4rem; padding: 0.65rem 1rem; border-radius: 10px; font-size: 0.875rem; font-weight: 600; color: var(--muted); background: transparent; border: none; cursor: pointer; transition: all 0.22s; white-space: nowrap; }
        .ec-tab-btn:hover { background: var(--light-bg); color: var(--primary); }
        .ec-tab-btn.active { background: var(--primary); color: #fff; box-shadow: 0 4px 14px rgba(10,36,99,0.25); }
        .ec-tab-count { font-size: 0.68rem; font-weight: 700; padding: 0.1rem 0.45rem; border-radius: 999px; }
        .ec-tab-btn.active .ec-tab-count { background: rgba(255,255,255,0.2); color: #fff; }
        .ec-tab-btn:not(.active) .ec-tab-count { background: var(--light-bg); color: var(--muted); }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* ── EC CARD ── */
        .ec-card { background: white; border-radius: 18px; border: 1px solid var(--border); box-shadow: 0 4px 16px rgba(10,36,99,0.06); overflow: hidden; margin-bottom: 1.5rem; }
        .ec-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .ec-card-header h3 { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 0.5rem; }
        .ec-card-body { padding: 1.5rem; }

        /* ── ALERTES ── */
        .ec-alert { display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem 1.25rem; border-radius: 12px; font-size: 0.88rem; margin-bottom: 1rem; }
        .ec-alert-warning { background: rgba(245,158,11,0.1);  border: 1px solid rgba(245,158,11,0.3); color: #92400e; }
        .ec-alert-success { background: rgba(16,185,129,0.1);  border: 1px solid rgba(16,185,129,0.3); color: #065f46; }
        .ec-alert-info    { background: rgba(30,64,175,0.08);  border: 1px solid rgba(30,64,175,0.2);  color: var(--primary); }
        .ec-alert-danger  { background: rgba(239,68,68,0.08);  border: 1px solid rgba(239,68,68,0.2);  color: #991b1b; }

        /* ── DOCUMENTS ── */
        .doc-item { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 0.75rem; background: #fafbfc; transition: all 0.2s; }
        .doc-item:hover { border-color: var(--primary-light); background: white; }
        .doc-item.uploaded { border-color: rgba(16,185,129,0.3); background: rgba(16,185,129,0.04); }
        .doc-item.refused  { border-color: rgba(239,68,68,0.3);  background: rgba(239,68,68,0.04); }
        .doc-item-left { display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0; }
        .doc-icon-wrap { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .doc-icon-pending  { background: rgba(100,116,139,0.1); color: var(--muted); }
        .doc-icon-uploaded { background: rgba(16,185,129,0.15); color: var(--success); }
        .doc-icon-refused  { background: rgba(239,68,68,0.1);   color: var(--danger); }
        .doc-name { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .doc-meta { font-size: 0.75rem; color: var(--muted); margin-top: 0.1rem; }
        .doc-obligatoire { display: inline-block; background: rgba(239,68,68,0.1); color: var(--danger); font-size: 0.68rem; padding: 0.1rem 0.45rem; border-radius: 999px; font-weight: 700; margin-left: 0.4rem; }
        .doc-facultatif  { display: inline-block; background: rgba(100,116,139,0.1); color: var(--muted); font-size: 0.68rem; padding: 0.1rem 0.45rem; border-radius: 999px; font-weight: 700; margin-left: 0.4rem; }
        .doc-status-badge { font-size: 0.72rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 999px; }
        .doc-status-en_attente { background: rgba(245,158,11,0.12); color: #92400e; }
        .doc-status-valide     { background: rgba(16,185,129,0.12); color: #065f46; }
        .doc-status-refuse     { background: rgba(239,68,68,0.12);  color: #991b1b; }
        .doc-file-link { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.82rem; color: var(--primary-light); text-decoration: none; font-weight: 600; }
        .doc-file-link:hover { text-decoration: underline; }
        .btn-upload-label { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.2s; border: 1.5px dashed var(--border); color: var(--primary); background: white; white-space: nowrap; }
        .btn-upload-label:hover { border-color: var(--primary); background: var(--primary-xlight); }
        .btn-upload-label.has-file { border-color: var(--success); color: var(--success); background: rgba(16,185,129,0.06); border-style: solid; }

        /* ── MESSAGERIE ── */
        .chat-container { height: 380px; overflow-y: auto; padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid var(--border); margin-bottom: 1rem; display: flex; flex-direction: column; gap: 0.75rem; scroll-behavior: smooth; }
        .message-bubble { display: flex; gap: 0.6rem; max-width: 80%; }
        .message-bubble.sent     { align-self: flex-end;   flex-direction: row-reverse; }
        .message-bubble.received { align-self: flex-start; }
        .bubble-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .bubble-content { display: flex; flex-direction: column; }
        .bubble-name { font-size: 0.72rem; font-weight: 700; color: var(--muted); margin-bottom: 0.25rem; }
        .bubble-text { padding: 0.75rem 1rem; border-radius: 16px; font-size: 0.88rem; line-height: 1.5; word-break: break-word; }
        .message-bubble.sent .bubble-text { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border-radius: 16px 4px 16px 16px; }
        .message-bubble.received .bubble-text { background: white; color: var(--text); border: 1px solid var(--border); border-radius: 4px 16px 16px 16px; }
        .bubble-time { font-size: 0.68rem; color: var(--muted); margin-top: 0.25rem; }
        .message-bubble.sent .bubble-time { text-align: right; }
        .chat-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: var(--muted); text-align: center; }
        .chat-empty i { font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.3; }
        .chat-form { display: flex; gap: 0.75rem; align-items: flex-end; }
        .chat-input { flex: 1; border: 1.5px solid var(--border); border-radius: 12px; padding: 0.75rem 1rem; font-family: var(--font-body); font-size: 0.9rem; resize: none; min-height: 48px; max-height: 120px; outline: none; transition: all 0.25s; background: #fafbfc; }
        .chat-input:focus { border-color: var(--primary-light); background: white; box-shadow: 0 0 0 0.2rem rgba(30,64,175,0.1); }
        .chat-send-btn { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; transition: all 0.2s; font-size: 1.1rem; }
        .chat-send-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(10,36,99,0.3); }

        /* ── BOUTON SUBMIT ── */
        .btn-form-submit { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; border-radius: 10px; padding: 0.5rem 1rem; font-weight: 700; font-size: 0.82rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem; transition: all 0.3s; }
        .btn-form-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(10,36,99,0.25); color: white; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .doc-item { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .message-bubble { max-width: 90%; }
            .ec-tab-btn { font-size: 0.8rem; padding: 0.55rem 0.6rem; min-width: 0; }
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
            <div class="brand-sub">Espace Client</div>
        </div>
    </a>
    <div class="topbar-user">
        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/avatar.png') }}"
             class="user-avatar" alt="Avatar">
        <div class="d-none d-md-block">
            <div style="font-size:.88rem;font-weight:600;">{{ auth()->user()->name }}</div>
            <div style="font-size:.72rem;color:var(--muted);">Client</div>
        </div>
    </div>
</header>

{{-- ════ CONTENU PRINCIPAL ════ --}}
<div class="main-content">
    <div class="container">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="ec-alert ec-alert-success mb-3" data-aos="fade-down">
                <i class="bi bi-check-circle-fill" style="flex-shrink:0;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="ec-alert ec-alert-danger mb-3" data-aos="fade-down">
                <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ════ HERO ════ --}}
        <div class="dossier-hero" data-aos="fade-up">
            <a href="{{ route('client.dashboard') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i> Retour à mes dossiers
            </a>
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div>
                    <h1 class="dossier-hero-title">
                        Dossier — {{ $dossier->service->nom ?? '—' }}
                    </h1>
                    <p class="dossier-hero-sub mb-2">
                        <i class="bi bi-geo-alt me-1"></i> {{ $dossier->service->pays ?? '—' }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-calendar me-1"></i> Créé le {{ $dossier->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
                <span class="status-badge status-badge-white">
                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                    {{ ucfirst(str_replace('_', ' ', $dossier->statut)) }}
                </span>
            </div>
            {{-- Message contextuel selon le statut --}}
            @if($dossier->statut === 'en_attente')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem;color:rgba(255,255,255,0.8);">
                    <i class="bi bi-clock-history"></i>
                    <span>Votre dossier est en attente — Envoyez vos documents pour accélérer le traitement.</span>
                </div>
            @elseif($dossier->statut === 'en_cours')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem;color:rgba(255,255,255,0.8);">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Votre dossier est en cours de traitement par notre équipe.</span>
                </div>
            @elseif($dossier->statut === 'valide')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem;color:rgba(255,255,255,0.8);">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Félicitations ! Votre dossier a été validé.</span>
                </div>
            @elseif($dossier->statut === 'refuse')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem;color:rgba(255,255,255,0.8);">
                    <i class="bi bi-x-circle-fill"></i>
                    <span>Votre dossier a été refusé. Contactez-nous pour plus d'informations.</span>
                </div>
            @endif
        </div>

        {{-- ════ ONGLETS ════ --}}
        {{--
            3 onglets : Documents | Étapes | Messages
            L'onglet Étapes est NOUVEAU côté client
            Le client voit les étapes en lecture seule (pas de formulaire de modification)
        --}}
        <div class="ec-tabs" data-aos="fade-up">
            <button class="ec-tab-btn active" id="btn-tab-documents" onclick="showTab('documents', this)">
                <i class="bi bi-file-earmark-text"></i> Documents
                <span class="ec-tab-count">{{ $dossier->documents->count() }}</span>
            </button>
            <button class="ec-tab-btn" id="btn-tab-etapes" onclick="showTab('etapes', this)">
                <i class="bi bi-list-check"></i> Étapes
                <span class="ec-tab-count">{{ $etapes->count() }}</span>
            </button>
            <button class="ec-tab-btn" id="btn-tab-messages" onclick="showTab('messages', this)">
                <i class="bi bi-chat-dots"></i> Messages
                <span class="ec-tab-count">{{ $messages->count() }}</span>
            </button>
        </div>

        {{-- ════ ONGLET 1 — DOCUMENTS ════ --}}
        <div class="tab-pane active" id="pane-documents" data-aos="fade-up">
            <div class="ec-card">
                <div class="ec-card-header">
                    <h3><i class="bi bi-file-earmark-text text-primary"></i> Documents requis</h3>
                    <span style="font-size:0.82rem;color:var(--muted);">
                        {{ $documentsAvecStatut->filter(fn($d) => $d['uploaded'])->count() }}
                        / {{ $documentsAvecStatut->count() }} envoyé(s)
                    </span>
                </div>
                <div class="ec-card-body">

                    <div class="ec-alert ec-alert-info mb-3">
                        <i class="bi bi-info-circle-fill" style="flex-shrink:0;"></i>
                        <div>Envoyez chaque document requis (PDF, JPG, PNG — max 5 Mo).</div>
                    </div>

                    @foreach($documentsAvecStatut as $item)
                        @php
                            $requis      = $item['requis'];
                            $uploaded    = $item['uploaded'];
                            $isUploaded  = $uploaded !== null;
                            $isRefused   = $isUploaded && $uploaded->statut === 'refuse';
                            $isValidated = $isUploaded && $uploaded->statut === 'valide';
                        @endphp

                        <div class="doc-item {{ $isUploaded ? ($isRefused ? 'refused' : 'uploaded') : '' }}">

                            {{-- Icône + infos du document --}}
                            <div class="doc-item-left">
                                <div class="doc-icon-wrap {{ $isUploaded ? ($isRefused ? 'doc-icon-refused' : 'doc-icon-uploaded') : 'doc-icon-pending' }}">
                                    <i class="bi bi-{{ $isUploaded ? ($isRefused ? 'x-circle-fill' : 'check-circle-fill') : 'file-earmark' }}"
                                       style="font-size:1.1rem;"></i>
                                </div>
                                <div>
                                    <div class="doc-name">
                                        {{ $requis->nom }}
                                        @if($requis->obligatoire)
                                            <span class="doc-obligatoire">obligatoire</span>
                                        @else
                                            <span class="doc-facultatif">facultatif</span>
                                        @endif
                                    </div>
                                    @if($isUploaded)
                                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                            <span class="doc-status-badge doc-status-{{ $uploaded->statut }}">
                                                @if($uploaded->statut === 'en_attente') En attente
                                                @elseif($uploaded->statut === 'valide')  Validé
                                                @elseif($uploaded->statut === 'refuse')  Refusé
                                                @else {{ ucfirst($uploaded->statut) }} @endif
                                            </span>
                                            <a href="{{ asset('storage/'.$uploaded->fichier) }}" target="_blank" class="doc-file-link">
                                                <i class="bi bi-eye"></i> Voir le fichier
                                            </a>
                                            {{-- Suppression possible seulement si pas encore validé --}}
                                            @if($uploaded->statut !== 'valide')
                                                <form action="{{ route('client.dossiers.documents.delete', [$dossier->id, $uploaded->id]) }}"
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Supprimer ce document ?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="doc-file-link"
                                                            style="background:none;border:none;padding:0;color:var(--danger);cursor:pointer;">
                                                        <i class="bi bi-trash3"></i> Supprimer
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        {{-- Commentaire de refus affiché en rouge --}}
                                        @if($isRefused && $uploaded->commentaire)
                                            <div class="mt-1" style="font-size:0.78rem;color:var(--danger);">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                {{ $uploaded->commentaire }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="doc-meta">En attente d'envoi</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Formulaire d'upload (désactivé si déjà validé) --}}
                            @if(!$isValidated)
                                <form action="{{ route('client.dossiers.documents.upload', $dossier->id) }}"
                                      method="POST" enctype="multipart/form-data"
                                      id="uploadForm{{ $requis->id }}"
                                      class="d-flex align-items-center gap-2 flex-shrink-0">
                                    @csrf
                                    <input type="hidden" name="document_requis_id" value="{{ $requis->id }}">

                                    <label for="file{{ $requis->id }}"
                                           class="btn-upload-label"
                                           id="label{{ $requis->id }}">
                                        <i class="bi bi-cloud-upload"></i>
                                        {{ $isUploaded ? 'Remplacer' : 'Envoyer' }}
                                    </label>
                                    <input type="file" id="file{{ $requis->id }}" name="fichier"
                                           hidden accept=".pdf,.jpg,.jpeg,.png,.webp"
                                           onchange="handleFileSelect(this, {{ $requis->id }})">

                                    <button type="submit" class="btn-form-submit d-none"
                                            id="submitBtn{{ $requis->id }}">
                                        <i class="bi bi-send"></i> Confirmer
                                    </button>
                                </form>
                            @else
                                <span style="font-size:0.78rem;color:var(--success);font-weight:600;">
                                    <i class="bi bi-shield-check me-1"></i> Validé
                                </span>
                            @endif

                        </div>
                    @endforeach

                    @if($documentsAvecStatut->isEmpty())
                        <div class="text-center py-4" style="color:var(--muted);">
                            <i class="bi bi-folder2-open" style="font-size:2rem;display:block;margin-bottom:0.5rem;opacity:0.3;"></i>
                            <p>Aucun document requis pour ce service.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ════ ONGLET 2 — ÉTAPES ════ --}}
        {{--
            NOUVEAU — Le client voit ici la progression de son dossier.
            C'est en LECTURE SEULE : seul l'admin peut modifier les statuts.
            Les statuts possibles : en_attente | en_cours | validée
        --}}
        <div class="tab-pane" id="pane-etapes">
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-list-check text-primary"></i> Progression de votre dossier</h3>
                    <span style="font-size:0.82rem;color:var(--muted);">
                        {{ $etapes->where('statut','validée')->count() }}
                        / {{ $etapes->count() }} étape(s) validée(s)
                    </span>
                </div>
                <div class="ec-card-body">

                    {{-- Barre de progression globale --}}
                    @php
                        $total   = $etapes->count();
                        $valides = $etapes->where('statut', 'validée')->count();
                        $pct     = $total > 0 ? round(($valides / $total) * 100) : 0;
                    @endphp

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span style="font-size:.82rem;font-weight:700;color:var(--primary);">Avancement global</span>
                            <span style="font-size:.82rem;font-weight:700;color:var(--primary);">{{ $pct }}%</span>
                        </div>
                        <div class="progress" style="height:10px;border-radius:999px;background:var(--light-bg);">
                            <div class="progress-bar" role="progressbar"
                                 style="width:{{ $pct }}%;background:linear-gradient(90deg,var(--primary),var(--primary-light));border-radius:999px;transition:width .8s ease;"
                                 aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    {{-- Liste des étapes (lecture seule pour le client) --}}
                    @forelse($etapes as $index => $dossierEtape)

                        <div style="
                            display:flex; align-items:center; gap:1rem;
                            padding:.85rem 1rem;
                            border-left: 3px solid {{ $dossierEtape->statut === 'validée' ? 'var(--success)' : ($dossierEtape->statut === 'en_cours' ? '#3b82f6' : 'var(--border)') }};
                            border-radius:0 12px 12px 0;
                            margin-bottom:.5rem;
                            background:{{ $dossierEtape->statut === 'validée' ? 'rgba(16,185,129,.04)' : ($dossierEtape->statut === 'en_cours' ? 'rgba(59,130,246,.04)' : '#fafbfc') }};
                            transition:all .2s;
                        ">

                            {{-- Icône circulaire --}}
                            <div style="
                                width:32px;height:32px;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                font-size:.8rem;font-weight:800;flex-shrink:0;
                                background:{{ $dossierEtape->statut === 'validée' ? 'rgba(16,185,129,.15)' : ($dossierEtape->statut === 'en_cours' ? 'rgba(59,130,246,.15)' : 'var(--light-bg)') }};
                                color:{{ $dossierEtape->statut === 'validée' ? 'var(--success)' : ($dossierEtape->statut === 'en_cours' ? '#1d4ed8' : 'var(--muted)') }};
                            ">
                                @if($dossierEtape->statut === 'validée')
                                    <i class="bi bi-check-lg"></i>
                                @elseif($dossierEtape->statut === 'en_cours')
                                    <i class="bi bi-arrow-repeat"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>

                            {{-- Nom de l'étape --}}
                            <div style="flex:1;min-width:0;">
                                <div style="
                                    font-size:.88rem;font-weight:600;
                                    color:{{ $dossierEtape->statut === 'validée' ? 'var(--success)' : ($dossierEtape->statut === 'en_cours' ? '#1d4ed8' : 'var(--muted)') }};
                                    {{ $dossierEtape->statut === 'validée' ? 'text-decoration:line-through;' : '' }}
                                ">
                                    {{-- Nom de l'étape via la relation etape --}}
                                    {{ $dossierEtape->etape->nom ?? 'Étape ' . ($index + 1) }}
                                </div>
                            </div>

                            {{-- Badge statut (lecture seule) --}}
                            @if($dossierEtape->statut === 'validée')
                                <span style="display:inline-flex;align-items:center;gap:.3rem;background:rgba(16,185,129,.12);color:#065f46;font-size:.7rem;font-weight:700;padding:.18rem .55rem;border-radius:999px;white-space:nowrap;">
                                    <i class="bi bi-check-circle-fill"></i> Validée
                                </span>
                            @elseif($dossierEtape->statut === 'en_cours')
                                <span style="display:inline-flex;align-items:center;gap:.3rem;background:rgba(59,130,246,.12);color:#1d4ed8;font-size:.7rem;font-weight:700;padding:.18rem .55rem;border-radius:999px;white-space:nowrap;">
                                    <i class="bi bi-arrow-repeat"></i> En cours
                                </span>
                            @else
                                <span style="display:inline-flex;align-items:center;gap:.3rem;background:rgba(245,158,11,.12);color:#92400e;font-size:.7rem;font-weight:700;padding:.18rem .55rem;border-radius:999px;white-space:nowrap;">
                                    <i class="bi bi-clock"></i> En attente
                                </span>
                            @endif

                        </div>

                    @empty
                        <div class="text-center py-4" style="color:var(--muted);">
                            <i class="bi bi-list-check" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3;"></i>
                            <p style="font-size:.88rem;">Aucune étape définie pour ce service.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- ════ ONGLET 3 — MESSAGERIE ════ --}}
        <div class="tab-pane" id="pane-messages">
            <div class="ec-card" data-aos="fade-up">
                <div class="ec-card-header">
                    <h3><i class="bi bi-chat-dots text-primary"></i> Messages</h3>
                    <span style="font-size:.82rem;color:var(--muted);">{{ $messages->count() }} message(s)</span>
                </div>
                <div class="ec-card-body">

                    {{-- Fil de messages --}}
                    <div class="chat-container" id="chatContainer">
                        @if($messages->isEmpty())
                            <div class="chat-empty">
                                <i class="bi bi-chat-square-dots"></i>
                                <p style="font-size:.88rem;">Aucun message pour le moment.</p>
                                <p style="font-size:.78rem;">Envoyez un message à notre équipe.</p>
                            </div>
                        @else
                            @foreach($messages as $message)
                                @php
                                    $isSent     = $message->sender_id === auth()->id();
                                    $avatarPath = $message->expediteur->avatar
                                        ? asset('storage/'.$message->expediteur->avatar)
                                        : asset('images/avatar.png');
                                @endphp
                                <div class="message-bubble {{ $isSent ? 'sent' : 'received' }}">
                                    <img src="{{ $avatarPath }}" class="bubble-avatar" alt="Avatar">
                                    <div class="bubble-content">
                                        <div class="bubble-name">
                                            {{ $isSent ? 'Vous' : ($message->expediteur->name ?? 'Équipe Elyon') }}
                                        </div>
                                        <div class="bubble-text">{{ $message->contenu }}</div>
                                        {{-- data-utc convertit en heure locale via JS --}}
                                        <div class="bubble-time msg-time"
                                             data-utc="{{ optional($message->created_at)->toISOString() }}">
                                            {{ optional($message->created_at)->format('d/m/Y à H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- Bouton effacer l'historique --}}
                    @if($messages->isNotEmpty())
                        <div class="d-flex justify-content-end mb-2">
                            <form action="{{ route('client.dossiers.messages.clear', $dossier->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Effacer tout l\'historique des messages ?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="background:none;border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:0.35rem 0.85rem;font-size:0.78rem;font-weight:600;color:var(--danger);cursor:pointer;transition:all 0.2s;">
                                    <i class="bi bi-trash3 me-1"></i> Effacer l'historique
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Formulaire d'envoi de message --}}
                    <form action="{{ route('client.dossiers.messages.store', $dossier->id) }}" method="POST">
                        @csrf
                        @error('contenu')
                            <div class="ec-alert ec-alert-danger mb-2">
                                <i class="bi bi-exclamation-circle" style="flex-shrink:0;"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="chat-form">
                            <textarea name="contenu" class="chat-input"
                                      placeholder="Écrivez votre message à notre équipe…"
                                      rows="1" maxlength="1000"
                                      required>{{ old('contenu') }}</textarea>
                            <button type="submit" class="chat-send-btn" title="Envoyer">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                        <div style="font-size:0.72rem;color:var(--muted);margin-top:0.4rem;">
                            Max. 1000 caractères
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 700, once: true, offset: 40 });

/* ══════════════════════════════════════════════
   NAVIGATION PAR ONGLETS
══════════════════════════════════════════════ */
function showTab(id, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.ec-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('pane-' + id)?.classList.add('active');
    btn.classList.add('active');
    if (id === 'messages') scrollChat();
}

/* ══════════════════════════════════════════════
   SCROLL EN BAS DU CHAT
══════════════════════════════════════════════ */
function scrollChat() {
    const c = document.getElementById('chatContainer');
    if (c) requestAnimationFrame(() => { c.scrollTop = c.scrollHeight; });
}

/* ══════════════════════════════════════════════
   CONVERSION DES DATES UTC → HEURE LOCALE
   Corrige le décalage entre la BDD (UTC) et
   le fuseau horaire local du navigateur
══════════════════════════════════════════════ */
function convertirDates() {
    document.querySelectorAll('.msg-time').forEach(el => {
        const utc = el.getAttribute('data-utc');
        if (!utc) return;
        const date = new Date(utc);
        el.textContent = date.toLocaleString('fr-FR', {
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    });
}

/* ══════════════════════════════════════════════
   GESTION SÉLECTION FICHIER POUR L'UPLOAD
   Met à jour le label et affiche le bouton Confirmer
══════════════════════════════════════════════ */
function handleFileSelect(input, docId) {
    const label     = document.getElementById('label' + docId);
    const submitBtn = document.getElementById('submitBtn' + docId);
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
        label.innerHTML = `<i class="bi bi-file-earmark-check"></i> ${fileName} (${fileSize} Mo)`;
        label.classList.add('has-file');
        if (submitBtn) submitBtn.classList.remove('d-none');
    }
}

/* ══════════════════════════════════════════════
   AUTO-RESIZE TEXTAREA
══════════════════════════════════════════════ */
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

/* ── Au chargement ── */
document.addEventListener('DOMContentLoaded', () => {
    scrollChat();
    convertirDates();
});

/* ── Ouvrir le bon onglet selon l'URL hash ── */
const hash = window.location.hash;
if (hash === '#etapes')   showTab('etapes',   document.getElementById('btn-tab-etapes'));
if (hash === '#messages') showTab('messages', document.getElementById('btn-tab-messages'));
</script>

</body>
</html>