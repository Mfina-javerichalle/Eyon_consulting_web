<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $service->nom }} — Elyon Consulting, accompagnement visa et études à l'étranger.">
    <title>{{ $service->nom }} — Elyon Consulting</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           VARIABLES
        ═══════════════════════════════════════════ */
        :root {
            --primary:#0a2463; --primary-mid:#0056A8; --primary-light:#1e40af;
            --primary-xlight:#dbeafe; --accent:#f0a500; --accent-light:#fbbf24;
            --dark:#07152b; --text:#1e293b; --muted:#64748b;
            --light-bg:#f8fafc; --border:#e2e8f0; --success:#10b981;
            --font-display:'Playfair Display',serif; --font-body:'DM Sans',sans-serif;
            --shadow:0 10px 40px rgba(10,36,99,0.10);
            --shadow-lg:0 20px 60px rgba(10,36,99,0.15);
            --radius:16px; --navbar-h:90px;
        }

        /* ═══════════════════════════════════════════
           RESET — BLOQUE SCROLL HORIZONTAL
        ═══════════════════════════════════════════ */
        *,*::before,*::after { box-sizing:border-box; }
        html { scroll-behavior:smooth; overflow-x:hidden; max-width:100%; }
        body { font-family:var(--font-body); color:var(--text); background:var(--light-bg); overflow-x:hidden; max-width:100%; position:relative; }
        img,svg { max-width:100%; height:auto; }

        /* ═══════════════════════════════════════════
           NAVBAR — 90px uniforme
        ═══════════════════════════════════════════ */
        header { position:fixed; top:0; left:0; width:100%; z-index:1050; }

        .navbar {
            height:var(--navbar-h);
            background:white;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            transition:all 0.3s ease;
            padding:0 1rem;
        }
        .navbar.scrolled { box-shadow:0 4px 20px rgba(0,0,0,0.12); }

        .navbar-brand img {
            height:62px; width:auto;
            border-radius:10px;
            box-shadow:0 4px 14px rgba(0,0,0,0.15);
            transition:transform 0.3s;
        }
        .navbar-brand img:hover { transform:scale(1.04); }

        .logo-text-container { display:flex; align-items:center; }
        .logo-text-wrapper { margin-left:10px; }
        .logo-text { font-family:var(--font-display); font-size:20px; font-weight:700; color:var(--primary); line-height:1.2; }
        .logo-subtext { font-size:12.5px; color:rgb(90,90,90); font-weight:400; margin-top:2px; }

        .navbar-collapse { justify-content:center; }
        .navbar-nav .nav-item .nav-link { font-size:15px; color:rgb(75,75,75); padding:0.5rem 0.85rem; transition:color 0.25s; }
        .navbar-nav .nav-item .nav-link:hover { color:var(--primary-mid); }

        .contact-btn { background-color:var(--primary); color:#fff !important; font-weight:600; border-radius:8px; padding:8px 18px; font-size:14px; transition:background 0.2s; white-space:nowrap; }
        .contact-btn:hover { background-color:var(--primary-mid); }

        .whatsapp-link { display:flex; align-items:center; font-weight:500; color:var(--primary) !important; text-decoration:none; white-space:nowrap; }
        .whatsapp-link:hover { opacity:0.8; }
        .whatsapp-number { margin-left:6px; font-size:0.88rem; }

        .navbar-toggler { border:none; padding:6px 10px; background:none; border-radius:8px; }
        .navbar-toggler:focus { box-shadow:none; outline:none; }

        @media (max-width:991.98px) { #navbarDesktop { display:none !important; } }

        /* ═══════════════════════════════════════════
           DROPDOWN SERVICES — DESKTOP
        ═══════════════════════════════════════════ */
        .services-dropdown {
            position:absolute; top:100%; left:50%;
            transform:translateX(-50%);
            width:min(750px,95vw); background:white;
            border-radius:12px;
            box-shadow:0 20px 40px rgba(0,123,255,0.15);
            border:1px solid #e3f2fd;
            opacity:0; visibility:hidden;
            transition:all 0.3s cubic-bezier(0.4,0,0.2,1);
            z-index:1060; margin-top:10px; overflow:hidden;
        }
        .services-dropdown.show { opacity:1; visibility:visible; transform:translateX(-50%) translateY(-5px); }
        .dropdown-content { padding:25px; }
        .dropdown-header { text-align:center; margin-bottom:20px; padding-bottom:16px; border-bottom:2px solid #e3f2fd; }
        .dropdown-header h3 { font-family:var(--font-display); color:var(--primary); font-size:1.3rem; font-weight:700; margin-bottom:6px; }
        .dropdown-header p { color:#64748b; margin:0; font-size:0.9rem; }
        .services-grid-dd { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:20px; }
        .service-item-dd { text-align:center; }
        .service-icon-dd { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px; color:white; font-size:1.1rem; }
        .service-item-dd h5 { color:var(--primary); font-size:0.92rem; font-weight:600; margin-bottom:8px; }
        .service-item-dd ul { list-style:none; padding:0; margin:0; font-size:0.82rem; color:#64748b; }
        .service-item-dd li { padding:2px 0; }
        .service-item-dd li::before { content:"✓"; color:#28a745; font-weight:bold; margin-right:4px; }
        .dropdown-footer-dd { padding-top:16px; border-top:2px solid #e3f2fd; }
        .dropdown-footer-dd .btn { background:linear-gradient(135deg,#007bff,var(--primary)); border:none; border-radius:8px; font-weight:600; color:white; }

        /* ═══════════════════════════════════════════
           MENU MOBILE — Panneau sombre identique
        ═══════════════════════════════════════════ */
        .mobile-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(7,21,43,0.65); z-index:2000;
            backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);
            cursor:pointer;
        }
        .mobile-overlay.active { display:block; }

        .mobile-menu {
            position:fixed; top:0; right:0;
            width:min(340px,90vw); height:100dvh;
            background:linear-gradient(180deg,#0d1f3c 0%,var(--dark) 100%);
            z-index:2100;
            transform:translateX(110%);
            transition:transform 0.38s cubic-bezier(0.4,0,0.2,1);
            display:flex; flex-direction:column;
            overflow-y:auto; overscroll-behavior:contain;
            box-shadow:-16px 0 60px rgba(0,0,0,0.45);
        }
        .mobile-menu.open { transform:translateX(0); }

        .mobile-menu-header {
            display:flex; align-items:center; justify-content:space-between;
            padding:1.25rem 1.5rem;
            background:rgba(255,255,255,0.03);
            border-bottom:1px solid rgba(255,255,255,0.07);
            flex-shrink:0;
        }
        .mobile-menu-logo { display:flex; align-items:center; gap:0.8rem; }
        .mobile-menu-logo img { height:52px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.35); }
        .mobile-menu-logo .brand-name { font-family:var(--font-display); font-size:1.1rem; font-weight:700; color:#fff; line-height:1.2; }
        .mobile-menu-logo .brand-sub { font-size:0.72rem; color:rgba(255,255,255,0.45); margin-top:2px; }

        .mobile-close-btn {
            width:38px; height:38px; border-radius:50%;
            border:1px solid rgba(255,255,255,0.14);
            background:rgba(255,255,255,0.06);
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; color:rgba(255,255,255,0.75);
            font-size:1rem; flex-shrink:0; transition:all 0.2s;
        }
        .mobile-close-btn:hover { background:rgba(255,255,255,0.14); color:#fff; transform:rotate(90deg); }

        .mobile-menu-body { padding:0.4rem 0; flex:1; }

        .mobile-section-title {
            font-size:0.63rem; font-weight:700;
            letter-spacing:0.15em; text-transform:uppercase;
            color:rgba(255,255,255,0.25); padding:1rem 1.5rem 0.3rem;
        }

        .mobile-nav-link {
            display:flex; align-items:center; justify-content:space-between;
            padding:0.85rem 1.5rem; font-size:0.94rem; font-weight:500;
            color:rgba(255,255,255,0.72); text-decoration:none;
            border-bottom:1px solid rgba(255,255,255,0.04);
            transition:all 0.2s ease; cursor:pointer;
        }
        .mobile-nav-link:hover { background:rgba(255,255,255,0.05); color:#fff; padding-left:1.75rem; }
        .mobile-nav-link.active { color:var(--accent-light); }
        .mobile-nav-link .link-left { display:flex; align-items:center; gap:0.75rem; }
        .mobile-nav-link .link-icon {
            width:36px; height:36px; border-radius:10px;
            background:rgba(255,255,255,0.06);
            border:1px solid rgba(255,255,255,0.08);
            display:flex; align-items:center; justify-content:center;
            font-size:0.9rem; color:rgba(255,255,255,0.6);
            flex-shrink:0; transition:all 0.2s;
        }
        .mobile-nav-link:hover .link-icon,
        .mobile-nav-link.active .link-icon { background:rgba(240,165,0,0.15); border-color:rgba(240,165,0,0.25); color:var(--accent-light); }
        .mobile-nav-link .chevron { font-size:0.72rem; color:rgba(255,255,255,0.25); transition:transform 0.28s; flex-shrink:0; }
        .mobile-nav-link.open .chevron { transform:rotate(90deg); color:var(--accent-light); }

        .mobile-submenu { display:none; background:rgba(0,0,0,0.18); border-bottom:1px solid rgba(255,255,255,0.05); }
        .mobile-submenu.open { display:block; }
        .mobile-submenu-cat { font-size:0.62rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255,255,255,0.25); padding:0.75rem 1.5rem 0.25rem; }
        .mobile-submenu-link { display:flex; align-items:center; gap:0.55rem; padding:0.6rem 1.5rem 0.6rem 1.75rem; font-size:0.87rem; color:rgba(255,255,255,0.58); text-decoration:none; transition:all 0.15s; }
        .mobile-submenu-link::before { content:""; width:5px; height:5px; border-radius:50%; background:var(--accent); opacity:0.55; flex-shrink:0; }
        .mobile-submenu-link:hover { color:rgba(255,255,255,0.9); background:rgba(255,255,255,0.04); padding-left:2rem; }
        .mobile-submenu-link:hover::before { opacity:1; }
        .mobile-submenu-all { display:flex; align-items:center; gap:0.5rem; padding:0.8rem 1.5rem; font-size:0.87rem; font-weight:700; color:var(--accent-light); text-decoration:none; border-top:1px solid rgba(255,255,255,0.06); margin-top:0.2rem; transition:color 0.2s; }
        .mobile-submenu-all:hover { color:white; }

        .mobile-nav-link.auth-login .link-icon  { background:rgba(30,64,175,.2); border-color:rgba(30,64,175,.3); color:#93c5fd; }
        .mobile-nav-link.auth-register .link-icon { background:rgba(16,185,129,.15); border-color:rgba(16,185,129,.25); color:#6ee7b7; }
        .mobile-nav-link.auth-logout { color:rgba(252,165,165,.75); }
        .mobile-nav-link.auth-logout .link-icon { background:rgba(239,68,68,.12); border-color:rgba(239,68,68,.2); color:#fca5a5; }
        .mobile-nav-link.auth-logout:hover { color:#fca5a5; }

        .mobile-menu-footer {
            padding:1.25rem 1.5rem;
            border-top:1px solid rgba(255,255,255,0.07);
            background:rgba(0,0,0,0.15);
            flex-shrink:0; display:flex; flex-direction:column; gap:0.65rem;
        }
        .btn-mobile-contact {
            display:flex; align-items:center; justify-content:center; gap:0.6rem;
            width:100%; padding:0.9rem 1rem;
            background:linear-gradient(135deg,var(--primary),var(--primary-light));
            color:white; border:none; border-radius:12px;
            font-size:0.92rem; font-weight:700; text-decoration:none;
            transition:all 0.25s; box-shadow:0 6px 20px rgba(10,36,99,0.35);
        }
        .btn-mobile-contact:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(10,36,99,.45); color:white; }
        .btn-mobile-whatsapp {
            display:flex; align-items:center; justify-content:center; gap:0.6rem;
            width:100%; padding:0.9rem 1rem;
            background:rgba(37,211,102,0.1); color:#4ade80;
            border:1px solid rgba(37,211,102,0.22); border-radius:12px;
            font-size:0.92rem; font-weight:600; text-decoration:none; transition:all 0.25s;
        }
        .btn-mobile-whatsapp:hover { background:rgba(37,211,102,.18); color:#86efac; }

        /* ═══════════════════════════════════════════
           MODALS
        ═══════════════════════════════════════════ */
        .modal { z-index:9999; }
        .modal-content { border-radius:20px; border:1px solid rgba(255,255,255,0.08); background:radial-gradient(circle at top left,#1e3a8a 0%,#071529 50%,#040712 100%); color:#f5f7ff; box-shadow:0 24px 60px rgba(0,0,0,0.55); overflow:hidden; }
        .modal-header { border-bottom:1px solid rgba(255,255,255,0.1); padding:1.5rem 1.75rem 1rem; }
        .modal-title { font-family:var(--font-display); font-weight:700; font-size:1.1rem; color:var(--accent-light); }
        .modal-header .btn-close { filter:invert(1) grayscale(1); }
        .modal-body { padding:1rem 1.75rem 1.75rem; }
        .modal-body .form-label { font-size:0.83rem; font-weight:600; color:rgba(220,228,255,0.9); margin-bottom:0.4rem; }
        .modal-body .form-control { background:rgba(5,16,40,0.85); border-radius:10px; border:1px solid rgba(100,120,200,0.5); color:#f5f7ff; font-size:0.9rem; padding:0.65rem 0.9rem; }
        .modal-body .form-control:focus { background:rgba(5,18,46,0.95); border-color:#497eff; box-shadow:0 0 0 0.2rem rgba(73,132,255,0.2); }
        .modal-body .form-control::placeholder { color:rgba(180,192,220,0.5); }
        .btn-modal-primary { border-radius:999px; padding:0.7rem 1rem; font-weight:700; font-size:0.9rem; background:linear-gradient(135deg,#497eff,#23b3ff); border:none; transition:all 0.3s; }
        .btn-modal-primary:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(73,132,255,0.4); }
        .btn-modal-success { border-radius:999px; padding:0.7rem 1rem; font-weight:700; font-size:0.9rem; background:linear-gradient(135deg,#10b981,#059669); border:none; transition:all 0.3s; }
        .btn-modal-success:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(16,185,129,0.4); }
        .modal-footer-link { color:rgba(180,200,255,0.7); font-size:0.82rem; text-align:center; margin-top:1rem; }
        .modal-footer-link a { color:var(--accent-light); text-decoration:none; font-weight:600; }

        /* ═══════════════════════════════════════════
           HERO DÉTAIL SERVICE
        ═══════════════════════════════════════════ */
        .service-detail-hero {
            background:linear-gradient(135deg,var(--primary) 0%,#1e3a8a 100%);
            color:white;
            padding-top:calc(var(--navbar-h) + 50px);
            padding-bottom:4rem;
            position:relative; overflow:hidden;
        }
        .service-detail-hero::before {
            content:""; position:absolute;
            width:500px; height:500px;
            background:rgba(255,255,255,0.04); border-radius:50%;
            top:-300px; right:-200px; pointer-events:none;
        }

        .back-link { color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.88rem; display:inline-flex; align-items:center; gap:0.4rem; transition:color 0.2s; margin-bottom:1.5rem; }
        .back-link:hover { color:white; }
        .hero-service-title { font-family:var(--font-display); font-size:clamp(1.8rem,5vw,3rem); font-weight:800; margin-bottom:1rem; }
        .hero-service-lead { font-size:clamp(0.9rem,2.5vw,1.05rem); color:rgba(255,255,255,0.8); max-width:600px; line-height:1.7; }

        .steps-nav-pills { display:flex; gap:0.75rem; flex-wrap:wrap; margin-top:2rem; }
        .step-pill { display:inline-flex; align-items:center; gap:0.6rem; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:rgba(255,255,255,0.85); padding:0.6rem 1.1rem; border-radius:999px; font-size:0.83rem; font-weight:600; text-decoration:none; transition:all 0.3s; cursor:pointer; }
        .step-pill:hover,.step-pill.active { background:rgba(255,255,255,0.25); color:white; border-color:rgba(255,255,255,0.5); }
        .step-pill-num { width:22px; height:22px; background:rgba(255,255,255,0.25); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.72rem; font-weight:800; }

        /* ═══════════════════════════════════════════
           CONTENU PRINCIPAL
        ═══════════════════════════════════════════ */
        .detail-content { padding:4rem 0; }

        .section-card { background:white; border-radius:20px; padding:2.25rem; box-shadow:0 8px 32px rgba(10,36,99,0.08); border:1px solid var(--border); margin-bottom:2rem; }
        .section-card-header { display:flex; align-items:center; gap:1rem; margin-bottom:1.75rem; padding-bottom:1.25rem; border-bottom:1px solid var(--border); }
        .section-card-icon { width:52px; height:52px; background:linear-gradient(135deg,var(--primary),var(--primary-light)); border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .section-card-icon i { font-size:1.4rem; color:white; }
        .section-card-header h2 { font-family:var(--font-display); font-size:clamp(1.1rem,3vw,1.4rem); font-weight:700; color:var(--primary); margin:0; }
        .section-card-header small { font-size:0.82rem; color:var(--muted); display:block; margin-top:0.15rem; }

        /* Documents */
        .doc-list { list-style:none; padding:0; margin:0; }
        .doc-list li { display:flex; align-items:flex-start; gap:0.75rem; padding:0.85rem 0; border-bottom:1px solid #f1f5f9; font-size:0.9rem; font-weight:500; color:var(--text); }
        .doc-list li:last-child { border-bottom:none; }
        .doc-icon { width:28px; height:28px; background:rgba(16,185,129,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .doc-icon i { color:var(--success); font-size:0.9rem; }
        .doc-icon.optional { background:rgba(100,116,139,0.1); }
        .doc-icon.optional i { color:var(--muted); }
        .badge-optional { display:inline-block; background:rgba(100,116,139,0.1); color:var(--muted); font-size:0.7rem; padding:0.1rem 0.5rem; border-radius:999px; font-weight:600; margin-left:0.5rem; }

        /* Étapes */
        .steps-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; }
        .step-card { background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #bfdbfe; border-radius:var(--radius); padding:1.25rem 1rem; text-align:center; transition:all 0.3s; }
        .step-card:hover { transform:translateY(-5px); box-shadow:0 12px 36px rgba(10,36,99,0.15); }
        .step-num { width:38px; height:38px; background:linear-gradient(135deg,var(--primary),var(--primary-light)); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:0.88rem; font-weight:800; color:white; margin:0 auto 0.85rem; box-shadow:0 4px 14px rgba(10,36,99,0.22); }
        .step-card h4 { font-size:0.88rem; font-weight:700; color:var(--primary); margin:0; line-height:1.4; }

        /* Infos Visa */
        .visa-info-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; }
        .visa-info-item { background:var(--light-bg); border:1px solid var(--border); border-radius:12px; padding:1.1rem; display:flex; align-items:flex-start; gap:0.75rem; }
        .visa-info-icon { width:36px; height:36px; background:var(--primary-xlight); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .visa-info-icon i { color:var(--primary-light); font-size:1rem; }
        .visa-info-label { font-size:0.7rem; color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
        .visa-info-value { font-size:0.88rem; font-weight:700; color:var(--primary); margin-top:0.2rem; }

        /* Sidebar */
        .sidebar-card { background:white; border-radius:20px; padding:1.75rem; box-shadow:0 8px 32px rgba(10,36,99,0.08); border:1px solid var(--border); position:sticky; top:calc(var(--navbar-h) + 20px); }
        .sidebar-card h3 { font-family:var(--font-display); font-size:1.05rem; font-weight:700; color:var(--primary); margin-bottom:1.25rem; }
        .sidebar-stat { display:flex; justify-content:space-between; align-items:center; padding:0.7rem 0; border-bottom:1px solid #f1f5f9; font-size:0.87rem; }
        .sidebar-stat:last-of-type { border-bottom:none; }
        .sidebar-stat .label { color:var(--muted); }
        .sidebar-stat .value { font-weight:700; color:var(--primary); }
        .btn-dossier { display:flex; align-items:center; justify-content:center; gap:0.5rem; background:linear-gradient(135deg,var(--primary),var(--primary-light)); color:white !important; border-radius:12px; padding:0.9rem; font-weight:700; text-decoration:none; font-size:0.88rem; transition:all 0.3s; box-shadow:0 4px 16px rgba(10,36,99,0.22); margin-top:1.1rem; }
        .btn-dossier:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(10,36,99,0.32); color:white !important; }

        /* CTA */
        .cta-detail { background:linear-gradient(135deg,var(--primary),var(--primary-light)); border-radius:22px; padding:3rem 2rem; text-align:center; color:white; box-shadow:var(--shadow-lg); }
        .cta-detail h3 { font-family:var(--font-display); font-size:clamp(1.4rem,4vw,1.8rem); font-weight:800; margin-bottom:0.75rem; }
        .cta-detail p { font-size:0.95rem; color:rgba(255,255,255,0.8); margin-bottom:1.75rem; }
        .btn-cta-white { background:white; color:var(--primary) !important; border-radius:999px; padding:0.85rem 1.75rem; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s; box-shadow:0 6px 20px rgba(0,0,0,0.15); }
        .btn-cta-white:hover { transform:translateY(-2px); box-shadow:0 14px 36px rgba(0,0,0,0.2); }
        .btn-cta-ghost { background:transparent; color:white !important; border:2px solid rgba(255,255,255,0.45); border-radius:999px; padding:0.85rem 1.75rem; font-weight:600; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s; }
        .btn-cta-ghost:hover { background:rgba(255,255,255,0.12); border-color:white; }

        /* Empty state */
        .empty-state { text-align:center; padding:2rem; color:var(--muted); }
        .empty-state i { font-size:2.5rem; display:block; margin-bottom:0.75rem; opacity:0.3; }

        /* ═══════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════ */
        .elyon-footer { background:#07152b; position:relative; overflow:hidden; }
        .elyon-footer::before { content:""; position:absolute; top:-40px; left:0; right:0; height:40px; background:#07152b; border-top-left-radius:50% 100%; border-top-right-radius:50% 100%; }
        .footer-title { font-size:0.82rem; letter-spacing:0.18em; text-transform:uppercase; color:#f0a23a; margin-bottom:1rem; }
        .footer-links a { color:#e3e7f2; font-size:0.88rem; text-decoration:none; display:block; margin-bottom:6px; }
        .footer-links a:hover { color:#fff; }
        .elyon-logo-placeholder { width:60px; height:60px; border-radius:16px; background:#fff; display:flex; align-items:center; justify-content:center; color:#1a315c; font-weight:700; font-size:16px; flex-shrink:0; }
        .footer-subtitle { font-size:0.78rem; letter-spacing:0.15em; text-transform:uppercase; color:#f0a23a; }
        .btn-footer-pill { border-radius:999px; background:#173a6d; color:#fff; border:none; font-size:0.78rem; padding:0.5rem 1.4rem; }
        .elyon-footer .icon-circle { background:#122543; color:#f0a23a; border-radius:10px; width:34px; height:34px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .btn-footer-contact { border-radius:999px; background:#1f57a8; color:#fff; border:none; font-weight:600; padding:0.65rem 1.1rem; }
        .btn-footer-contact:hover { background:#1a488d; color:#fff; }
        .social-icon { width:46px; height:46px; border-radius:12px; background:#122543; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; transition:background 0.2s; }
        .social-icon:hover { background:#1f57a8; }

        /* ═══════════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════════ */
        @media (max-width:991.98px) {
            .sidebar-card { position:static; margin-top:0; }
        }
        @media (max-width:767.98px) {
            .service-detail-hero { padding-top:calc(var(--navbar-h) + 25px); padding-bottom:2.5rem; }
            .section-card { padding:1.25rem; }
            .steps-grid { grid-template-columns:repeat(2,1fr); }
            .cta-detail { padding:2rem 1.25rem; }
            .cta-detail .d-flex { flex-direction:column; align-items:stretch; }
            .btn-cta-white, .btn-cta-ghost { justify-content:center; }
            .elyon-footer::before { display:none; }
        }
        @media (max-width:480px) {
            .steps-grid { grid-template-columns:1fr; }
            .visa-info-grid { grid-template-columns:1fr; }
            .steps-nav-pills { gap:0.5rem; }
            .step-pill { font-size:0.78rem; padding:0.5rem 0.85rem; }
        }
    </style>
</head>
<body>

{{-- ════ OVERLAY + MENU MOBILE ════ --}}
<div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>

<nav class="mobile-menu" id="mobileMenu" aria-label="Menu mobile" aria-hidden="true">
    <div class="mobile-menu-header">
        <div class="mobile-menu-logo">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Elyon">
            <div>
                <div class="brand-name">Elyon Consulting</div>
                <div class="brand-sub">Accompagnement voyage</div>
            </div>
        </div>
        <button class="mobile-close-btn" onclick="closeMobileMenu()" aria-label="Fermer">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="mobile-menu-body">
        <div class="mobile-section-title">Navigation</div>

        <a href="{{ route('home') }}" class="mobile-nav-link">
            <span class="link-left"><span class="link-icon"><i class="bi bi-house-fill"></i></span>Accueil</span>
        </a>
        <a href="{{ route('home') }}#about-section" class="mobile-nav-link" onclick="closeMobileMenu()">
            <span class="link-left"><span class="link-icon"><i class="bi bi-info-circle-fill"></i></span>À propos</span>
        </a>

        <div class="mobile-nav-link active" id="servicesToggle" onclick="toggleServicesSubmenu(event)">
            <span class="link-left"><span class="link-icon"><i class="bi bi-briefcase-fill"></i></span>Nos services</span>
            <i class="bi bi-chevron-right chevron"></i>
        </div>
        <div class="mobile-submenu open" id="servicesSubmenu">
            <div class="mobile-submenu-cat">Destinations</div>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">France – Études</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Canada – Tourisme</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Belgique – Études</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Luxembourg – Études</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">USA – Tourisme</a>
            <div class="mobile-submenu-cat">Accompagnement</div>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Visa & Dossier</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Billets avion</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Logement</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-link" onclick="closeMobileMenu()">Blocage de fonds</a>
            <a href="{{ route('services.index') }}" class="mobile-submenu-all" onclick="closeMobileMenu()">
                <i class="bi bi-arrow-right-circle-fill"></i> Voir tous les services
            </a>
        </div>

        <a href="{{ route('contact') }}" class="mobile-nav-link" onclick="closeMobileMenu()">
            <span class="link-left"><span class="link-icon"><i class="bi bi-envelope-fill"></i></span>Contact</span>
        </a>

        <div class="mobile-section-title">Mon compte</div>

        @auth
            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'client.dashboard') }}"
               class="mobile-nav-link" onclick="closeMobileMenu()">
                <span class="link-left"><span class="link-icon"><i class="bi bi-person-circle"></i></span>Mon espace</span>
            </a>
            <div class="mobile-nav-link auth-logout" onclick="document.getElementById('logout-nav-form').submit();">
                <span class="link-left"><span class="link-icon"><i class="bi bi-box-arrow-right"></i></span>Déconnexion</span>
            </div>
        @else
            <div class="mobile-nav-link auth-login"
                 onclick="closeMobileMenu(); setTimeout(()=>new bootstrap.Modal(document.getElementById('loginModal')).show(),200);">
                <span class="link-left"><span class="link-icon"><i class="bi bi-box-arrow-in-right"></i></span>Connexion</span>
            </div>
            <div class="mobile-nav-link auth-register"
                 onclick="closeMobileMenu(); setTimeout(()=>new bootstrap.Modal(document.getElementById('registerModal')).show(),200);">
                <span class="link-left"><span class="link-icon"><i class="bi bi-person-plus-fill"></i></span>Inscription gratuite</span>
            </div>
        @endauth
    </div>

    <div class="mobile-menu-footer">
        <a href="{{ route('contact') }}" class="btn-mobile-contact" onclick="closeMobileMenu()">
            <i class="bi bi-send-fill"></i> Nous contacter
        </a>
        <a href="https://wa.me/242044714707" target="_blank" rel="noopener" class="btn-mobile-whatsapp">
            <i class="bi bi-whatsapp fs-5"></i> +242 04 471 47 07
        </a>
    </div>
</nav>

{{-- ════ NAVBAR ════ --}}
<header data-aos="fade-down">
    <nav class="navbar navbar-expand-lg navbar-light bg-white" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="logo-text-container">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Elyon Consulting">
                    <div class="logo-text-wrapper">
                        <div class="logo-text">Elyon Consulting</div>
                        <div class="logo-subtext">Accompagnement voyage</div>
                    </div>
                </div>
            </a>

            <button class="navbar-toggler d-lg-none" type="button"
                    onclick="openMobileMenu()" aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarDesktop" class="collapse navbar-collapse d-lg-flex">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about-section">À propos</a></li>
                    <li class="nav-item position-relative">
                        <a class="nav-link active" href="{{ route('services.index') }}" id="servicesDesktopLink">
                            Nos services <i class="bi bi-chevron-down ms-1" style="font-size:.7rem;" id="servicesArrow"></i>
                        </a>
                        <div class="services-dropdown" id="servicesDropdown">
                            <div class="dropdown-content">
                                <div class="dropdown-header">
                                    <h3><i class="bi bi-briefcase"></i> Nos Services</h3>
                                    <p>Solutions complètes pour vos projets voyage & études</p>
                                </div>
                                <div class="services-grid-dd">
                                    <div class="service-item-dd">
                                        <div class="service-icon-dd" style="background:linear-gradient(135deg,#007bff,#004080);"><i class="bi bi-globe"></i></div>
                                        <h5>Destinations</h5>
                                        <ul><li>France – Études</li><li>Canada – Tourisme</li><li>Belgique – Études</li><li>Luxembourg – Études</li><li>USA – Tourisme</li></ul>
                                    </div>
                                    <div class="service-item-dd">
                                        <div class="service-icon-dd" style="background:linear-gradient(135deg,#28a745,#1e7e34);"><i class="bi bi-check-circle"></i></div>
                                        <h5>Accompagnement</h5>
                                        <ul><li>Visa & Dossier</li><li>Billets avion</li><li>Logement</li><li>Blocage de fond</li><li>Installation</li></ul>
                                    </div>
                                    <div class="service-item-dd">
                                        <div class="service-icon-dd" style="background:linear-gradient(135deg,#17a2b8,#117a8b);"><i class="bi bi-star"></i></div>
                                        <h5>Expertise</h5>
                                        <ul><li>Orientation études</li><li>Entretien visa</li><li>Installation</li></ul>
                                    </div>
                                </div>
                                <div class="dropdown-footer-dd">
                                    <a href="{{ route('services.index') }}" class="btn btn-primary w-100 text-white">
                                        Voir tous les services <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a href="{{ route('contact') }}" class="btn contact-btn"><i class="bi bi-send-fill me-1"></i> Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link whatsapp-link" href="https://wa.me/242044714707" target="_blank" rel="noopener">
                            <i class="bi bi-whatsapp fs-5"></i><span class="whatsapp-number">+242 04 471 47 07</span>
                        </a>
                    </li>
                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/avatar.png') }}"
                                     class="rounded-circle border" style="width:34px;height:34px;object-fit:cover;" alt="Avatar">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard Admin</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('client.dashboard') }}"><i class="bi bi-person-circle me-2 text-primary"></i> Mon espace</a></li>
                                @endif
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="document.getElementById('logout-nav-form').submit();"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                        <form id="logout-nav-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    @else
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" style="color:var(--text);text-decoration:none;">
                                <i class="bi bi-person-circle" style="font-size:1.5rem;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="bi bi-box-arrow-in-right me-2 text-primary"></i> Connexion</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="bi bi-person-plus me-2 text-success"></i> Inscription</a></li>
                            </ul>
                        </div>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

{{-- ════ MODALS ════ --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="bi bi-box-arrow-in-right me-2"></i>Connexion</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                @if(session('login_error'))<div class="alert alert-danger py-2 mb-3 rounded-3" style="font-size:.83rem;"><i class="bi bi-exclamation-circle me-1"></i> {{ session('login_error') }}<br><a href="#" class="text-danger fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" style="font-size:.82rem;"><i class="bi bi-key me-1"></i> Réinitialiser mon mot de passe</a></div>@endif
                @if(session('success'))<div class="alert alert-success py-2 mb-3 rounded-3" style="font-size:.83rem;"><i class="bi bi-check-circle me-1"></i> {{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('login') }}">@csrf
                    <div class="mb-2"><input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">@error('email')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror</div>
                    <div class="mb-2"><input type="password" name="password" placeholder="Mot de passe" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">@error('password')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror</div>
                    <div class="text-end mb-3"><a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" style="font-size:.8rem;color:rgba(180,200,255,.7);text-decoration:none;">Mot de passe oublié ?</a></div>
                    <button type="submit" class="btn btn-modal-primary w-100"><i class="bi bi-box-arrow-in-right me-2"></i> Se connecter</button>
                </form>
                <p class="modal-footer-link mt-3">Pas encore de compte ? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">S'inscrire gratuitement</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="bi bi-key me-2"></i>Mot de passe oublié</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                @if(session('reset_success'))<div class="alert alert-success py-2 mb-3 rounded-3" style="font-size:.83rem;"><i class="bi bi-check-circle me-1"></i> {{ session('reset_success') }}</div>@endif
                @if(session('reset_error'))<div class="alert alert-danger py-2 mb-3 rounded-3" style="font-size:.83rem;"><i class="bi bi-exclamation-circle me-1"></i> {{ session('reset_error') }}</div>@endif
                <p style="color:rgba(220,228,255,.8);font-size:.85rem;margin-bottom:1.25rem;"><i class="bi bi-info-circle me-1"></i> Entrez votre email pour recevoir un lien de réinitialisation.</p>
                <form method="POST" action="{{ route('password.email') }}">@csrf
                    <div class="mb-3"><label class="form-label">Adresse email</label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="votre@email.com" value="{{ old('email') }}" required autocomplete="email">@error('email')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror</div>
                    <button type="submit" class="btn btn-modal-primary w-100"><i class="bi bi-send me-2"></i> Envoyer le lien</button>
                </form>
                <p class="modal-footer-link mt-3">Vous vous souvenez ? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Créer un compte</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div id="registerMessage"></div>
                <form id="registerForm" method="POST" action="{{ route('register') }}">@csrf
                    <div class="mb-3"><label class="form-label">Nom complet</label><input type="text" name="name" class="form-control" placeholder="Jean Dupont" value="{{ old('name') }}" required autocomplete="name"></div>
                    <div class="mb-3"><label class="form-label">Adresse email</label><input type="email" name="email" class="form-control" placeholder="votre@email.com" value="{{ old('email') }}" required autocomplete="email"></div>
                    <div class="mb-3"><label class="form-label">Téléphone <span style="color:rgba(180,200,255,.5);font-size:.78rem;">(optionnel)</span></label><input type="text" name="telephone" class="form-control" placeholder="+242 06 000 00 00" value="{{ old('telephone') }}"></div>
                    <div class="mb-3"><label class="form-label">Mot de passe</label><input type="password" name="password" class="form-control" placeholder="Minimum 8 caractères" required autocomplete="new-password"></div>
                    <div class="mb-3"><label class="form-label">Confirmer le mot de passe</label><input type="password" name="password_confirmation" class="form-control" placeholder="Répétez votre mot de passe" required autocomplete="new-password"></div>
                    <input type="hidden" name="role" value="client">
                    <button type="submit" class="btn btn-modal-success w-100"><i class="bi bi-person-check me-2"></i> Créer mon compte</button>
                </form>
                <p class="modal-footer-link mt-3">Déjà un compte ? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>

{{-- ════ HERO ════ --}}
<section class="service-detail-hero">
    <div class="container">
        <a href="{{ route('services.index') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Retour aux services
        </a>
        <h1 class="hero-service-title" data-aos="fade-up">{{ $service->nom }}</h1>
        <p class="hero-service-lead" data-aos="fade-up" data-aos-delay="100">
            {{ $service->description ?? 'Découvrez la procédure complète pour ce service.' }}
        </p>
        <div class="steps-nav-pills" data-aos="fade-up" data-aos-delay="200">
            <a href="#documents" class="step-pill"><span class="step-pill-num">1</span> Documents requis</a>
            <a href="#etapes" class="step-pill"><span class="step-pill-num">2</span> Étapes</a>
            @if($infosVisa)
                <a href="#infos-visa" class="step-pill"><span class="step-pill-num">3</span> Infos Visa</a>
            @endif
        </div>
    </div>
</section>

{{-- ════ CONTENU PRINCIPAL ════ --}}
<div class="detail-content">
    <div class="container">
        <div class="row g-4">

            {{-- Colonne principale --}}
            <div class="col-lg-8">

                {{-- Documents requis --}}
                <div class="section-card" id="documents" data-aos="fade-up">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="bi bi-file-earmark-text"></i></div>
                        <div><h2>Documents requis</h2><small>Pièces justificatives à préparer pour votre dossier</small></div>
                    </div>
                    @if($documents->isEmpty())
                        <div class="empty-state"><i class="bi bi-folder2-open"></i><p>Aucun document spécifié pour ce service.</p></div>
                    @else
                        <ul class="doc-list">
                            @foreach($documents as $doc)
                                <li>
                                    <div class="doc-icon {{ !$doc->obligatoire ? 'optional' : '' }}">
                                        <i class="bi bi-{{ $doc->obligatoire ? 'check-circle-fill' : 'circle' }}"></i>
                                    </div>
                                    <span>{{ $doc->nom }}@if(!$doc->obligatoire)<span class="badge-optional">facultatif</span>@endif</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- Étapes --}}
                <div class="section-card" id="etapes" data-aos="fade-up">
                    <div class="section-card-header">
                        <div class="section-card-icon" style="background:linear-gradient(135deg,#059669,#047857);"><i class="bi bi-list-ol"></i></div>
                        <div><h2>Processus complet</h2><small>Les étapes pour finaliser votre dossier</small></div>
                    </div>
                    @if($etapes->isEmpty())
                        <div class="empty-state"><i class="bi bi-diagram-3"></i><p>Aucune étape définie pour ce service.</p></div>
                    @else
                        <div class="steps-grid">
                            @foreach($etapes as $etape)
                                <div class="step-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 60 }}">
                                    <div class="step-num">{{ str_pad($etape->ordre,2,'0',STR_PAD_LEFT) }}</div>
                                    <h4>{{ $etape->nom }}</h4>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Infos Visa --}}
                @if($infosVisa)
                    <div class="section-card" id="infos-visa" data-aos="fade-up">
                        <div class="section-card-header">
                            <div class="section-card-icon" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);"><i class="bi bi-passport"></i></div>
                            <div><h2>Informations Visa</h2><small>Délais, frais et coordonnées de l'ambassade</small></div>
                        </div>
                        <div class="visa-info-grid">
                            @if($infosVisa->delai)
                                <div class="visa-info-item"><div class="visa-info-icon"><i class="bi bi-clock"></i></div><div><div class="visa-info-label">Délai de traitement</div><div class="visa-info-value">{{ $infosVisa->delai }}</div></div></div>
                            @endif
                            @if($infosVisa->frais)
                                <div class="visa-info-item"><div class="visa-info-icon"><i class="bi bi-cash-coin"></i></div><div><div class="visa-info-label">Frais visa</div><div class="visa-info-value">{{ $infosVisa->frais }}</div></div></div>
                            @endif
                            @if($infosVisa->ambassade)
                                <div class="visa-info-item"><div class="visa-info-icon"><i class="bi bi-building"></i></div><div><div class="visa-info-label">Ambassade</div><div class="visa-info-value">{{ $infosVisa->ambassade }}</div></div></div>
                            @endif
                            @if($infosVisa->notes)
                                <div class="visa-info-item" style="grid-column:1/-1;"><div class="visa-info-icon"><i class="bi bi-info-circle"></i></div><div><div class="visa-info-label">Notes importantes</div><div class="visa-info-value" style="font-weight:400;font-size:.88rem;">{{ $infosVisa->notes }}</div></div></div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="sidebar-card" data-aos="fade-left">
                    <h3><i class="bi bi-info-circle me-2 text-primary"></i>Résumé du service</h3>
                    <div class="sidebar-stat"><span class="label">Destination</span><span class="value">{{ $service->pays }}</span></div>
                    <div class="sidebar-stat"><span class="label">Documents requis</span><span class="value">{{ $documents->count() }}</span></div>
                    <div class="sidebar-stat"><span class="label">Obligatoires</span><span class="value">{{ $documents->where('obligatoire',true)->count() }}</span></div>
                    <div class="sidebar-stat"><span class="label">Étapes</span><span class="value">{{ $etapes->count() }}</span></div>
                    @if($infosVisa && $infosVisa->delai)<div class="sidebar-stat"><span class="label">Délai estimé</span><span class="value">{{ $infosVisa->delai }}</span></div>@endif
                    @if($infosVisa && $infosVisa->frais)<div class="sidebar-stat"><span class="label">Frais visa</span><span class="value" style="color:var(--accent);">{{ $infosVisa->frais }}</span></div>@endif
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="btn-dossier"><i class="bi bi-folder-plus"></i> Créer mon dossier</a>
                    @else
                        <a href="#" class="btn-dossier" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="bi bi-person-plus"></i> Commencer maintenant</a>
                        <p style="font-size:.78rem;color:var(--muted);text-align:center;margin-top:.75rem;">Déjà un compte ? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" style="color:var(--primary-light);">Se connecter</a></p>
                    @endauth
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-detail mt-5" data-aos="zoom-in">
            <h3>Prêt à commencer votre procédure ?</h3>
            <p>Notre équipe vous accompagne à chaque étape. Démarrez dès aujourd'hui.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('services.index') }}" class="btn-cta-ghost"><i class="bi bi-arrow-left"></i> Tous les services</a>
                <a href="{{ route('contact') }}" class="btn-cta-white"><i class="bi bi-telephone-fill"></i> Demander un accompagnement</a>
            </div>
        </div>
    </div>
</div>

{{-- ════ FOOTER ════ --}}
<footer class="elyon-footer text-white pt-5 pb-4">
    <div class="container">
        <div class="row align-items-start g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="d-flex align-items-center mb-3 gap-3">
                    <span class="elyon-logo-placeholder">EC</span>
                    <div><h3 class="mb-1 fw-bold" style="font-size:clamp(.9rem,2.5vw,1.2rem);">ELYON CONSULTING</h3><p class="mb-0 footer-subtitle">CONSEIL & ACCOMPAGNEMENT</p></div>
                </div>
                <p class="small mb-2">Le premier pas pour étudier à l'étranger.</p>
            </div>
            <div class="col-lg-2 col-md-6 col-6" data-aos="fade-up" data-aos-delay="50">
                <h6 class="footer-title">NAVIGATION</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('services.index') }}">Nos services</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <h6 class="footer-title">POINTE-NOIRE</h6>
                <div class="d-flex mb-3 gap-3"><div class="icon-circle"><i class="bi bi-geo-alt"></i></div><p class="mb-0 small">N°29 Avenue du Caire, quartier Foucks</p></div>
                <div class="d-flex gap-3"><div class="icon-circle"><i class="bi bi-telephone"></i></div><div><p class="mb-0 small">+242 06 827 74 01</p><p class="mb-0 small">+242 04 471 47 07</p></div></div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
                <h6 class="footer-title">BRAZZAVILLE</h6>
                <div class="d-flex mb-3 gap-3"><div class="icon-circle"><i class="bi bi-geo-alt"></i></div><p class="mb-0 small">Vers Saint Exupéry, en face du CFAI, quartier Bacongo</p></div>
                <a href="{{ route('contact') }}" class="btn btn-footer-contact w-100"><span class="me-2">➤</span> Nous contacter</a>
            </div>
        </div>
        <div class="row mt-4 align-items-center">
            <div class="col-lg-6"><div class="d-flex gap-2"><a href="#" class="social-icon"><i class="bi bi-facebook"></i></a><a href="#" class="social-icon"><i class="bi bi-instagram"></i></a><a href="https://wa.me/242044714707" class="social-icon"><i class="bi bi-whatsapp"></i></a></div></div>
            <div class="col-lg-6 text-lg-end mt-3 mt-lg-0"><p class="small mb-0" style="color:rgba(255,255,255,.28);">© {{ date('Y') }} Elyon Consulting — Tous droits réservés</p></div>
        </div>
    </div>
</footer>

{{-- ════ SCRIPTS ════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
/* ── 1. AOS ── */
AOS.init({ duration:800, once:true, offset:60, easing:'ease-out-cubic' });

/* ── 2. Navbar scroll ── */
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 30);
});

/* ── 3. Menu mobile ── */
function openMobileMenu() {
    document.getElementById('mobileMenu').classList.add('open');
    document.getElementById('mobileOverlay').classList.add('active');
    document.getElementById('mobileMenu').setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden';
}
function closeMobileMenu() {
    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('mobileOverlay').classList.remove('active');
    document.getElementById('mobileMenu').setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMobileMenu(); });

/* ── 4. Sous-menu services mobile ── */
function toggleServicesSubmenu(e) {
    e.preventDefault();
    const toggle  = document.getElementById('servicesToggle');
    const submenu = document.getElementById('servicesSubmenu');
    const isOpen  = submenu.classList.toggle('open');
    toggle.classList.toggle('open', isOpen);
}

/* ── 5. Dropdown services desktop ── */
(function() {
    const navItem  = document.querySelector('#navbarDesktop .nav-item.position-relative');
    const dropdown = document.getElementById('servicesDropdown');
    const arrow    = document.getElementById('servicesArrow');
    if (!navItem || !dropdown) return;
    function openDD()  { dropdown.classList.add('show');    if(arrow) arrow.style.transform='rotate(180deg)'; }
    function closeDD() { dropdown.classList.remove('show'); if(arrow) arrow.style.transform='rotate(0deg)'; }
    navItem.addEventListener('mouseenter', openDD);
    navItem.addEventListener('mouseleave', closeDD);
})();

/* ── 6. Pills navigation actives au scroll ── */
const sections = ['documents','etapes','infos-visa'];
const pills    = document.querySelectorAll('.step-pill');
window.addEventListener('scroll', function() {
    let current = '';
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el && window.scrollY >= el.offsetTop - 120) current = id;
    });
    pills.forEach(pill => {
        pill.classList.remove('active');
        if (pill.getAttribute('href') === '#' + current) pill.classList.add('active');
    });
});

/* ── 7. Inscription AJAX ── */
$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $('#registerMessage').html('');
        $.ajax({
            url: "{{ route('register') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#registerMessage').html('<div class="alert alert-success py-2 rounded-3" style="font-size:.83rem;"><i class="bi bi-check-circle me-1"></i> Inscription réussie ! <a href="#" class="text-warning" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a></div>');
                $('#registerForm')[0].reset();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let html = '<div class="alert alert-danger py-2 rounded-3" style="font-size:.83rem;"><ul class="mb-0 ps-3">';
                $.each(errors, function(key, val) { html += '<li>' + val[0] + '</li>'; });
                html += '</ul></div>';
                $('#registerMessage').html(html);
            }
        });
    });
});

/* ── 8. Ouverture automatique modals ── */
@if(session('open_forgot_modal'))
    document.addEventListener('DOMContentLoaded', function() { new bootstrap.Modal(document.getElementById('forgotPasswordModal')).show(); });
@endif
@if(session('open_login_modal') || session('login_error') || session('success'))
    document.addEventListener('DOMContentLoaded', function() { new bootstrap.Modal(document.getElementById('loginModal')).show(); });
@endif
@if($errors->has('email') && session('reset_error'))
    document.addEventListener('DOMContentLoaded', function() { new bootstrap.Modal(document.getElementById('forgotPasswordModal')).show(); });
@endif
</script>

</body>
</html>