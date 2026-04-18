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
            --accent-light:  #fbbf24;
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
            --sidebar-w:     270px;
            --topbar-h:      72px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-body); color: var(--text); background: var(--light-bg); min-height: 100vh; }

        /* ═══════════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════════ */
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
        .topbar-brand img { height: 40px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.10); }
        .brand-name { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); }
        .brand-sub { font-size: 0.7rem; color: var(--muted); }
        .topbar-user { display: flex; align-items: center; gap: 0.75rem; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
        .user-greeting { font-size: 0.88rem; font-weight: 600; color: var(--text); }
        .user-role { font-size: 0.72rem; color: var(--muted); }

        /* ═══════════════════════════════════════════
           CONTENU PRINCIPAL
        ═══════════════════════════════════════════ */
        .main-content { padding-top: calc(var(--topbar-h) + 2rem); padding-bottom: 3rem; }

        /* ═══════════════════════════════════════════
           EN-TÊTE DU DOSSIER
        ═══════════════════════════════════════════ */
        .dossier-hero {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 20px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .dossier-hero::before {
            content: "";
            position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .dossier-hero-title { font-family: var(--font-display); font-size: 1.6rem; font-weight: 800; margin-bottom: 0.5rem; }
        .dossier-hero-sub { font-size: 0.9rem; color: rgba(255,255,255,0.75); }
        .back-btn { display: inline-flex; align-items: center; gap: 0.5rem; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: color 0.2s; margin-bottom: 1.25rem; }
        .back-btn:hover { color: white; }

        /* ═══════════════════════════════════════════
           BADGES STATUT
        ═══════════════════════════════════════════ */
        .status-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.85rem; border-radius: 999px; font-size: 0.82rem; font-weight: 700; }
        .status-en_attente { background: rgba(245,158,11,0.15); color: #92400e; }
        .status-en_cours   { background: rgba(59,130,246,0.15);  color: #1d4ed8; }
        .status-valide     { background: rgba(16,185,129,0.15);  color: #065f46; }
        .status-refuse     { background: rgba(239,68,68,0.15);   color: #991b1b; }

        /* Variante white pour le hero --*/
        .status-badge-white { background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); }

        /* ═══════════════════════════════════════════
           EC CARD — Cartes de contenu
        ═══════════════════════════════════════════ */
        .ec-card { background: white; border-radius: 18px; border: 1px solid var(--border); box-shadow: 0 4px 16px rgba(10,36,99,0.06); overflow: hidden; margin-bottom: 1.5rem; }
        .ec-card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .ec-card-header h3 { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 0.5rem; }
        .ec-card-body { padding: 1.5rem; }

        /* ═══════════════════════════════════════════
           ALERTES
        ═══════════════════════════════════════════ */
        .ec-alert { display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem 1.25rem; border-radius: 12px; font-size: 0.88rem; margin-bottom: 1rem; }
        .ec-alert-warning { background: rgba(245,158,11,0.1);  border: 1px solid rgba(245,158,11,0.3); color: #92400e; }
        .ec-alert-success { background: rgba(16,185,129,0.1);  border: 1px solid rgba(16,185,129,0.3); color: #065f46; }
        .ec-alert-info    { background: rgba(30,64,175,0.08);  border: 1px solid rgba(30,64,175,0.2);  color: var(--primary); }
        .ec-alert-danger  { background: rgba(239,68,68,0.08);  border: 1px solid rgba(239,68,68,0.2);  color: #991b1b; }

        /* ═══════════════════════════════════════════
           LISTE DOCUMENTS REQUIS + UPLOAD
        ═══════════════════════════════════════════ */
        .doc-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            background: #fafbfc;
            transition: all 0.2s;
        }
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

        /* Bouton upload discret --*/
        .btn-upload-label { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.2s; border: 1.5px dashed var(--border); color: var(--primary); background: white; white-space: nowrap; }
        .btn-upload-label:hover { border-color: var(--primary); background: var(--primary-xlight); }
        .btn-upload-label.has-file { border-color: var(--success); color: var(--success); background: rgba(16,185,129,0.06); border-style: solid; }

        /* Lien vers fichier uploadé --*/
        .doc-file-link { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.82rem; color: var(--primary-light); text-decoration: none; font-weight: 600; }
        .doc-file-link:hover { text-decoration: underline; }

        /* Badge statut document --*/
        .doc-status-badge { font-size: 0.72rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 999px; }
        .doc-status-en_attente { background: rgba(245,158,11,0.12); color: #92400e; }
        .doc-status-valide     { background: rgba(16,185,129,0.12); color: #065f46; }
        .doc-status-refuse     { background: rgba(239,68,68,0.12);  color: #991b1b; }

        /* ═══════════════════════════════════════════
           MESSAGERIE
        ═══════════════════════════════════════════ */
        .chat-container {
            height: 380px;
            overflow-y: auto;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            scroll-behavior: smooth;
        }

        /* Bulle de message --*/
        .message-bubble { display: flex; gap: 0.6rem; max-width: 80%; }
        .message-bubble.sent     { align-self: flex-end;   flex-direction: row-reverse; }
        .message-bubble.received { align-self: flex-start; flex-direction: row; }

        .bubble-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

        .bubble-content { display: flex; flex-direction: column; }
        .bubble-name { font-size: 0.72rem; font-weight: 700; color: var(--muted); margin-bottom: 0.25rem; }
        .bubble-sent .bubble-name { text-align: right; }

        .bubble-text {
            padding: 0.75rem 1rem;
            border-radius: 16px;
            font-size: 0.88rem;
            line-height: 1.5;
            word-break: break-word;
        }
        .message-bubble.sent .bubble-text {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: 16px 4px 16px 16px;
        }
        .message-bubble.received .bubble-text {
            background: white;
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 4px 16px 16px 16px;
        }
        .bubble-time { font-size: 0.68rem; color: var(--muted); margin-top: 0.25rem; }
        .message-bubble.sent .bubble-time { text-align: right; }

        /* État vide messagerie --*/
        .chat-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: var(--muted); text-align: center; }
        .chat-empty i { font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.3; }

        /* Formulaire d'envoi de message --*/
        .chat-form { display: flex; gap: 0.75rem; align-items: flex-end; }
        .chat-input { flex: 1; border: 1.5px solid var(--border); border-radius: 12px; padding: 0.75rem 1rem; font-family: var(--font-body); font-size: 0.9rem; resize: none; min-height: 48px; max-height: 120px; outline: none; transition: all 0.25s; background: #fafbfc; }
        .chat-input:focus { border-color: var(--primary-light); background: white; box-shadow: 0 0 0 0.2rem rgba(30,64,175,0.1); }
        .chat-send-btn { width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; transition: all 0.2s; font-size: 1.1rem; }
        .chat-send-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(10,36,99,0.3); }

        /* ═══════════════════════════════════════════
           BOUTONS
        ═══════════════════════════════════════════ */
        .btn-form-submit { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; border-radius: 10px; padding: 0.75rem 1.5rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; text-decoration: none; }
        .btn-form-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(10,36,99,0.25); color: white; }

        /* ═══════════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════════ */
        @media (max-width: 768px) {
            .doc-item { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .message-bubble { max-width: 90%; }
        }
    </style>
</head>
<body>

{{-- ════════════════════════════════════════════════
     TOPBAR
════════════════════════════════════════════════ --}}
<header class="ec-topbar">
    <a class="topbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Elyon">
        <div>
            <div class="brand-name">Elyon Consulting</div>
            <div class="brand-sub">Espace Client</div>
        </div>
    </a>
    <div class="topbar-user">
<img src="{{ auth()->user()->avatar 
    ? asset('storage/' . auth()->user()->avatar) 
    : asset('images/avatar.png') }}" class="user-avatar" alt="Avatar">
        <div class="d-none d-md-block">
            <div class="user-greeting">{{ auth()->user()->name }}</div>
            <div class="user-role">Client</div>
        </div>
    </div>
</header>



{{-- ════════════════════════════════════════════════
     CONTENU PRINCIPAL
════════════════════════════════════════════════ --}}
<div class="main-content">
    <div class="container">

        {{-- Messages flash --}}
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

        {{-- ════════════════════════════════════════
             EN-TÊTE DU DOSSIER
        ════════════════════════════════════════ --}}
        <div class="dossier-hero" data-aos="fade-up">
            {{-- Lien retour vers le dashboard --}}
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
                {{-- Statut du dossier --}}
                <span class="status-badge status-badge-white">
                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                    {{ ucfirst(str_replace('_', ' ', $dossier->statut)) }}
                </span>
            </div>

            {{-- Message d'information selon le statut --}}
            @if($dossier->statut === 'en_attente')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem; color:rgba(255,255,255,0.8);">
                    <i class="bi bi-clock-history"></i>
                    <span>Votre dossier est en attente — Envoyez vos documents pour accélérer le traitement.</span>
                </div>
            @elseif($dossier->statut === 'en_cours')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem; color:rgba(255,255,255,0.8);">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Votre dossier est en cours de traitement par notre équipe.</span>
                </div>
            @elseif($dossier->statut === 'valide')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem; color:rgba(255,255,255,0.8);">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Félicitations ! Votre dossier a été validé.</span>
                </div>
            @elseif($dossier->statut === 'refuse')
                <div class="mt-3 d-flex align-items-center gap-2" style="font-size:0.85rem; color:rgba(255,255,255,0.8);">
                    <i class="bi bi-x-circle-fill"></i>
                    <span>Votre dossier a été refusé. Contactez-nous pour plus d'informations.</span>
                </div>
            @endif
        </div>

        <div class="row g-4">

            {{-- ════════════════════════════════════════
                 COLONNE GAUCHE : Documents
            ════════════════════════════════════════ --}}
            <div class="col-lg-7">

                {{-- SECTION DOCUMENTS REQUIS --}}
               <div class="ec-card" data-aos="fade-up">
    <div class="ec-card-header">
        <h3>
            <i class="bi bi-file-earmark-text text-primary"></i>
            Documents requis
        </h3>
        <span style="font-size:0.82rem; color:var(--muted);">
            {{ $documentsAvecStatut->filter(fn($d) => $d['uploaded'])->count() }}
            /
            {{ $documentsAvecStatut->count() }} envoyé(s)
        </span>
    </div>
    <div class="ec-card-body">

        <div class="ec-alert ec-alert-info mb-3">
            <i class="bi bi-info-circle-fill" style="flex-shrink:0;"></i>
            <div>
                Envoyez chaque document requis (PDF, JPG, PNG — max 5 Mo).
            </div>
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

                {{-- Icône + nom du document --}}
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
                                    @else {{ ucfirst($uploaded->statut) }}
                                    @endif
                                </span>
                                <a href="{{ asset('storage/' . $uploaded->fichier) }}"
                                   target="_blank" class="doc-file-link">
                                    <i class="bi bi-eye"></i> Voir le fichier
                                </a>
                                @if($uploaded->statut !== 'valide')
                                    <form action="{{ route('client.dossiers.documents.delete', [$dossier->id, $uploaded->id]) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Supprimer ce document ? Cette action est irréversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="doc-file-link"
                                                style="background:none;border:none;padding:0;color:var(--danger);cursor:pointer;"
                                                title="Supprimer ce document">
                                            <i class="bi bi-trash3"></i> Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @if($isRefused && $uploaded->commentaire)
                                <div class="mt-1" style="font-size:0.78rem; color:var(--danger);">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $uploaded->commentaire }}
                                </div>
                            @endif
                        @else
                            <div class="doc-meta">En attente d'envoi</div>
                        @endif
                    </div>
                </div>

                {{-- Formulaire d'envoi (désactivé si validé) --}}
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
                                id="submitBtn{{ $requis->id }}"
                                style="padding:0.5rem 1rem; font-size:0.82rem;">
                            <i class="bi bi-send"></i> Confirmer
                        </button>
                    </form>
                @else
                    <span style="font-size:0.78rem; color:var(--success); font-weight:600;">
                        <i class="bi bi-shield-check me-1"></i> Validé
                    </span>
                @endif

            </div>
        @endforeach

        @if($documentsAvecStatut->isEmpty())
            <div class="text-center py-4" style="color:var(--muted);">
                <i class="bi bi-folder2-open" style="font-size:2rem; display:block; margin-bottom:0.5rem; opacity:0.3;"></i>
                <p>Aucun document requis pour ce service.</p>
            </div>
        @endif

    </div>
</div>

            </div>

            {{-- ════════════════════════════════════════
                 COLONNE DROITE : Messagerie
            ════════════════════════════════════════ --}}
            <div class="col-lg-5">

                {{-- SECTION MESSAGERIE --}}
                <div class="ec-card" data-aos="fade-left">
                    <div class="ec-card-header">
                        <h3>
                            <i class="bi bi-chat-dots text-primary"></i>
                            Messages
                        </h3>
                        {{-- Nombre de messages --}}
                        <span style="font-size:0.82rem; color:var(--muted);">
                            {{ $messages->count() }} message(s)
                        </span>
                    </div>
                    <div class="ec-card-body">

                        {{-- Zone d'affichage des messages --}}
                        <div class="chat-container" id="chatContainer">
                            @if($messages->isEmpty())
                                {{-- État vide --}}
                                <div class="chat-empty">
                                    <i class="bi bi-chat-square-dots"></i>
                                    <p style="font-size:0.88rem;">Aucun message pour le moment.</p>
                                    <p style="font-size:0.78rem;">Envoyez un message à notre équipe.</p>
                                </div>
                            @else
                                {{-- Affichage de chaque message --}}
                                @foreach($messages as $message)
                                    @php
                                        $isSent = $message->sender_id === auth()->id();
                                        $avatarPath = $message->expediteur->avatar
                                            ? asset('storage/' . $message->expediteur->avatar)
                                            : asset('images/avatar.png');
                                    @endphp

                                    <div class="message-bubble {{ $isSent ? 'sent' : 'received' }}">
                                        {{-- Avatar de l'expéditeur --}}
                                        <img src="{{ $avatarPath }}" class="bubble-avatar" alt="Avatar">

                                        <div class="bubble-content">
                                            {{-- Nom de l'expéditeur --}}
                                            <div class="bubble-name">
                                                {{ $isSent ? 'Vous' : $message->expediteur->name }}
                                            </div>
                                            {{-- Texte du message --}}
                                            <div class="bubble-text">
                                                {{ $message->contenu }}
                                            </div>
                                            {{-- Heure du message --}}
                                            <div class="bubble-time">
                                                {{ $message->created_at->format('d/m/Y à H:i') }}
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
                                      onsubmit="return confirm('Effacer tout l\'historique des messages ? Cette action est irréversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background:none;border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:0.35rem 0.85rem;font-size:0.78rem;font-weight:600;color:var(--danger);cursor:pointer;transition:all 0.2s;">
                                        <i class="bi bi-trash3 me-1"></i> Effacer l'historique
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Formulaire d'envoi de message --}}
                        <form action="{{ route('client.dossiers.messages.store', $dossier->id) }}"
                              method="POST">
                            @csrf

                            @error('contenu')
                                <div class="ec-alert ec-alert-danger mb-2">
                                    <i class="bi bi-exclamation-circle" style="flex-shrink:0;"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="chat-form">
                                {{-- Champ de saisie du message --}}
                                <textarea name="contenu"
                                          class="chat-input"
                                          placeholder="Écrivez votre message…"
                                          rows="1"
                                          maxlength="1000"
                                          required>{{ old('contenu') }}</textarea>

                                {{-- Bouton d'envoi --}}
                                <button type="submit" class="chat-send-btn" title="Envoyer">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                            <div style="font-size:0.72rem; color:var(--muted); margin-top:0.4rem;">
                                Max. 1000 caractères
                            </div>
                        </form>

                    </div>
                </div>

                {{-- Résumé du dossier --}}
                <div class="ec-card" data-aos="fade-left" data-aos-delay="100">
                    <div class="ec-card-header">
                        <h3><i class="bi bi-info-circle text-primary"></i> Résumé</h3>
                    </div>
                    <div class="ec-card-body">
                        <div style="display:grid; gap:0.75rem;">
                            <div style="display:flex; justify-content:space-between; font-size:0.88rem; padding-bottom:0.75rem; border-bottom:1px solid #f1f5f9;">
                                <span style="color:var(--muted);">Service</span>
                                <span style="font-weight:600;">{{ $dossier->service->nom ?? '—' }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.88rem; padding-bottom:0.75rem; border-bottom:1px solid #f1f5f9;">
                                <span style="color:var(--muted);">Destination</span>
                                <span style="font-weight:600;">{{ $dossier->service->pays ?? '—' }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.88rem; padding-bottom:0.75rem; border-bottom:1px solid #f1f5f9;">
                                <span style="color:var(--muted);">Documents</span>
                                <span style="font-weight:600;">
                                    {{ $documentsAvecStatut->filter(fn($d) => $d['uploaded'])->count() }}
                                    / {{ $documentsAvecStatut->count() }}
                                </span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.88rem; padding-bottom:0.75rem; border-bottom:1px solid #f1f5f9;">
                                <span style="color:var(--muted);">Messages</span>
                                <span style="font-weight:600;">{{ $messages->count() }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.88rem;">
                                <span style="color:var(--muted);">Statut</span>
                                <span class="status-badge status-{{ $dossier->statut }}">
                                    <i class="bi bi-circle-fill" style="font-size:0.4rem;"></i>
                                    {{ ucfirst(str_replace('_', ' ', $dossier->statut)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- ════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    /* ═══════════════════════════════════════════════════════
       1. INITIALISATION AOS
    ═══════════════════════════════════════════════════════ */
    AOS.init({ duration: 700, once: true, offset: 40 });

    /* ═══════════════════════════════════════════════════════
       2. SCROLL AUTOMATIQUE EN BAS DU CHAT
       Permet de toujours voir le dernier message
    ═══════════════════════════════════════════════════════ */
    const chatContainer = document.getElementById('chatContainer');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    /* ═══════════════════════════════════════════════════════
       3. GESTION SÉLECTION FICHIER POUR L'UPLOAD
       Quand l'utilisateur sélectionne un fichier :
       - Met à jour le label avec le nom du fichier
       - Affiche le bouton "Envoyer"
    ═══════════════════════════════════════════════════════ */
    function handleFileSelect(input, docId) {
        const label     = document.getElementById('label' + docId);
        const submitBtn = document.getElementById('submitBtn' + docId);

        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);

            // Mettre à jour le label avec le nom du fichier
            label.innerHTML = `<i class="bi bi-file-earmark-check"></i> ${fileName} (${fileSize} Mo)`;
            label.classList.add('has-file');

            // Afficher le bouton envoyer
            if (submitBtn) submitBtn.classList.remove('d-none');
        }
    }

    /* ═══════════════════════════════════════════════════════
       4. AUTO-RESIZE DU TEXTAREA DE MESSAGERIE
       Agrandit automatiquement le champ selon le contenu
    ═══════════════════════════════════════════════════════ */
    const chatInput = document.querySelector('.chat-input');
    if (chatInput) {
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Envoyer avec Ctrl+Entrée ou Cmd+Entrée
        chatInput.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }
</script>

</body>
</html>