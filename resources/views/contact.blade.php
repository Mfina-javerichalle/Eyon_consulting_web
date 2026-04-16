<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contactez Elyon Consulting — Réponse sous 24h pour vos questions visa, études et accompagnement.">
    <title>Contactez-nous — Elyon Consulting</title>

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
            --light-bg:#f8fafc; --border:#e2e8f0;
            --success:#10b981; --danger:#ef4444;
            --font-display:'Playfair Display',serif; --font-body:'DM Sans',sans-serif;
            --shadow:0 10px 40px rgba(10,36,99,0.10);
            --shadow-lg:0 20px 60px rgba(10,36,99,0.15);
            --navbar-h:90px;
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

        .navbar-brand img { height:62px; width:auto; border-radius:10px; box-shadow:0 4px 14px rgba(0,0,0,0.15); transition:transform 0.3s; }
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
           MENU MOBILE — Panneau sombre
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
            background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08);
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
           HERO CONTACT — padding basé sur navbar 90px
        ═══════════════════════════════════════════ */
        .contact-hero {
            background:linear-gradient(135deg,var(--primary) 0%,#1e3a8a 100%);
            color:white;
            padding-top:calc(var(--navbar-h) + 70px);
            padding-bottom:90px;
            position:relative; overflow:hidden;
        }
        .contact-hero::before { content:""; position:absolute; width:500px; height:500px; background:rgba(255,255,255,0.04); border-radius:50%; top:-300px; right:-200px; pointer-events:none; }
        .contact-hero::after { content:""; position:absolute; bottom:-1px; left:0; right:0; height:60px; background:var(--light-bg); clip-path:ellipse(62% 100% at 50% 100%); }

        .hero-label { display:inline-block; background:rgba(138,184,232,0.12); color:#8AB8E8; font-size:0.72rem; font-weight:600; letter-spacing:2px; text-transform:uppercase; padding:6px 14px; border-radius:100px; margin-bottom:1.25rem; border:1px solid rgba(138,184,232,0.25); }
        .hero-contact-title { font-family:var(--font-display); font-size:clamp(1.8rem,5vw,3rem); font-weight:800; margin-bottom:1rem; }
        .hero-contact-title span { color:#8AB8E8; }
        .hero-contact-lead { font-size:clamp(0.9rem,2.5vw,1.05rem); color:rgba(255,255,255,0.7); max-width:500px; line-height:1.7; }

        /* ═══════════════════════════════════════════
           FORMULAIRE
        ═══════════════════════════════════════════ */
        .contact-content { padding:4rem 0 5rem; }

        .form-card { background:white; border-radius:20px; padding:2.5rem; box-shadow:0 8px 32px rgba(10,36,99,0.08); border:1px solid var(--border); }
        .form-card h2 { font-family:var(--font-display); font-size:1.5rem; font-weight:700; color:var(--primary); margin-bottom:0.3rem; }
        .form-subtitle { font-size:0.85rem; color:var(--muted); margin-bottom:2rem; }

        .field-group { margin-bottom:1.25rem; }
        .field-label { display:block; font-size:0.78rem; font-weight:700; color:var(--primary); letter-spacing:0.06em; text-transform:uppercase; margin-bottom:0.5rem; }
        .field-input { width:100%; padding:0.7rem 1rem; border:1.5px solid var(--border); border-radius:10px; font-family:var(--font-body); font-size:0.9rem; color:var(--text); background:var(--light-bg); outline:none; transition:all 0.25s; appearance:none; }
        .field-input:focus { border-color:var(--primary-light); background:#fff; box-shadow:0 0 0 3px rgba(10,36,99,0.08); }
        .field-input.is-invalid { border-color:var(--danger); }
        textarea.field-input { resize:vertical; min-height:130px; }

        .select-wrap { position:relative; }
        .select-wrap::after { content:""; position:absolute; right:14px; top:50%; transform:translateY(-50%); width:0; height:0; border-left:5px solid transparent; border-right:5px solid transparent; border-top:5px solid var(--muted); pointer-events:none; }

        .btn-submit { width:100%; background:linear-gradient(135deg,var(--primary),var(--primary-light)); color:#fff; border:none; padding:0.85rem; border-radius:10px; font-family:var(--font-body); font-size:0.95rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:0.6rem; transition:all 0.3s; margin-top:0.5rem; }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(10,36,99,0.28); }

        /* Alertes */
        .alert-success-ec { background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); color:#065f46; border-radius:12px; padding:1rem 1.25rem; font-size:0.88rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:0.75rem; }
        .alert-danger-ec { background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2); color:#991b1b; border-radius:12px; padding:1rem 1.25rem; font-size:0.88rem; margin-bottom:1.5rem; }

        /* ═══════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════ */
        .contact-sidebar { display:flex; flex-direction:column; gap:1.25rem; }
        .info-card { background:white; border-radius:20px; padding:1.75rem; box-shadow:0 8px 32px rgba(10,36,99,0.08); border:1px solid var(--border); }
        .info-card-title { font-size:0.65rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--muted); margin-bottom:1.25rem; }

        .contact-item { display:flex; align-items:flex-start; gap:0.9rem; padding:0.85rem 0; border-bottom:1px solid #f1f5f9; }
        .contact-item:last-child { border-bottom:none; padding-bottom:0; }
        .contact-item:first-child { padding-top:0; }
        .contact-icon { width:38px; height:38px; border-radius:10px; background:var(--primary-xlight); display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:background 0.2s; }
        .contact-icon i { color:var(--primary-light); font-size:1rem; }
        .contact-item:hover .contact-icon { background:var(--primary); }
        .contact-item:hover .contact-icon i { color:#fff; }
        .contact-label { font-size:0.72rem; color:var(--muted); margin-bottom:0.2rem; }
        .contact-value { font-size:0.88rem; font-weight:600; color:var(--text); text-decoration:none; transition:color 0.2s; }
        .contact-value:hover { color:var(--primary-light); }

        /* Horaires */
        .hours-grid { display:grid; gap:0.75rem; }
        .hour-row { display:flex; justify-content:space-between; align-items:center; }
        .hour-day { font-size:0.88rem; color:var(--text); font-weight:500; }
        .hour-badge { background:var(--primary-xlight); color:var(--primary); font-size:0.78rem; font-weight:600; padding:0.25rem 0.75rem; border-radius:999px; }
        .hour-badge.closed { background:#f1f5f9; color:var(--muted); }

        /* Carte promo */
        .promo-card { background:linear-gradient(135deg,var(--primary),var(--dark)); border-radius:20px; padding:1.75rem; display:flex; align-items:center; gap:1rem; position:relative; overflow:hidden; }
        .promo-card::before { content:""; position:absolute; right:-30px; top:-30px; width:100px; height:100px; background:rgba(255,255,255,0.06); border-radius:50%; }
        .promo-icon { width:48px; height:48px; background:rgba(255,255,255,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(255,255,255,0.15); }
        .promo-icon i { color:#8AB8E8; font-size:1.3rem; }
        .promo-title { color:#8AB8E8; font-size:0.88rem; font-weight:700; margin-bottom:0.2rem; }
        .promo-sub { color:rgba(255,255,255,0.5); font-size:0.78rem; }

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
        @media (max-width:767.98px) {
            .contact-hero { padding-top:calc(var(--navbar-h) + 30px); padding-bottom:70px; }
            .form-card { padding:1.5rem; }
            .elyon-footer::before { display:none; }
        }
        @media (max-width:575.98px) {
            .contact-content { padding:2.5rem 0 3rem; }
            .promo-card { flex-direction:column; text-align:center; }
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

        <div class="mobile-nav-link" id="servicesToggle" onclick="toggleServicesSubmenu(event)">
            <span class="link-left"><span class="link-icon"><i class="bi bi-briefcase-fill"></i></span>Nos services</span>
            <i class="bi bi-chevron-right chevron"></i>
        </div>
        <div class="mobile-submenu" id="servicesSubmenu">
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

        {{-- Contact actif sur cette page --}}
        <a href="{{ route('contact') }}" class="mobile-nav-link active" onclick="closeMobileMenu()">
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
                        <a class="nav-link" href="{{ route('services.index') }}" id="servicesDesktopLink">
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
                    <li class="nav-item">
                        <a href="{{ route('contact') }}" class="btn contact-btn active">
                            <i class="bi bi-send-fill me-1"></i> Contact
                        </a>
                    </li>
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
<section class="contact-hero">
    <div class="container">
        <div data-aos="fade-up">
            <span class="hero-label">Contact</span>
            <h1 class="hero-contact-title">Parlons de <span>votre projet</span></h1>
            <p class="hero-contact-lead">Notre équipe vous répond sous 24h. N'hésitez pas à nous écrire pour toute question sur nos services.</p>
        </div>
    </div>
</section>

{{-- ════ FORMULAIRE + SIDEBAR ════ --}}
<section class="contact-content">
    <div class="container">
        <div class="row g-4">

            {{-- Formulaire contact --}}
            <div class="col-lg-7" data-aos="fade-up">
                <div class="form-card">
                    <h2>Envoyer un message</h2>
                    <p class="form-subtitle">Tous les champs marqués d'un * sont obligatoires.</p>

                    {{-- Message succès --}}
                    @if(session('contact_success'))
                        <div class="alert-success-ec">
                            <i class="bi bi-check-circle-fill" style="font-size:1.1rem;flex-shrink:0;"></i>
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    {{-- Erreurs de validation --}}
                    @if($errors->any())
                        <div class="alert-danger-ec">
                            <strong><i class="bi bi-exclamation-circle me-1"></i> Veuillez corriger les erreurs :</strong>
                            <ul class="mt-2 mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li style="font-size:.83rem;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulaire sécurisé avec @csrf --}}
                    <form action="{{ route('contact.send') }}" method="POST" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label" for="contact_name">Nom complet *</label>
                                    <input type="text" id="contact_name" name="name"
                                           class="field-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           value="{{ old('name') }}"
                                           placeholder="Jean Dupont"
                                           autocomplete="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label" for="contact_email">Adresse email *</label>
                                    <input type="email" id="contact_email" name="email"
                                           class="field-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                           value="{{ old('email') }}"
                                           placeholder="votre@email.com"
                                           autocomplete="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label" for="contact_phone">Téléphone</label>
                                    <input type="tel" id="contact_phone" name="phone"
                                           class="field-input"
                                           value="{{ old('phone') }}"
                                           placeholder="+242 0X XXX XXXX"
                                           autocomplete="tel">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label" for="contact_subject">Sujet *</label>
                                    <div class="select-wrap">
                                        <select id="contact_subject" name="subject"
                                                class="field-input {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                                                required>
                                            <option value="">— Choisir un sujet —</option>
                                            <option value="Visa"    {{ old('subject') == 'Visa'     ? 'selected' : '' }}>Visa</option>
                                            <option value="Études"  {{ old('subject') == 'Études'   ? 'selected' : '' }}>Études</option>
                                            <option value="Billets" {{ old('subject') == 'Billets'  ? 'selected' : '' }}>Billets</option>
                                            <option value="Logement"{{ old('subject') == 'Logement' ? 'selected' : '' }}>Logement</option>
                                            <option value="Autre"   {{ old('subject') == 'Autre'    ? 'selected' : '' }}>Autre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field-group">
                                    <label class="field-label" for="contact_message">Votre message *</label>
                                    <textarea id="contact_message" name="message"
                                              class="field-input {{ $errors->has('message') ? 'is-invalid' : '' }}"
                                              placeholder="Décrivez votre demande en quelques mots…"
                                              required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-send-fill"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sidebar coordonnées --}}
            <div class="col-lg-5">
                <div class="contact-sidebar">

                    <div class="info-card" data-aos="fade-left" data-aos-delay="100">
                        <div class="info-card-title">Nos coordonnées</div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                            <div>
                                <div class="contact-label">Email</div>
                                <a href="mailto:elyonconsulting242@gmail.com" class="contact-value">elyonconsulting242@gmail.com</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                            <div>
                                <div class="contact-label">Téléphone Pointe-Noire</div>
                                <a href="tel:+242044714707" class="contact-value">+242 04 471 47 07</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="bi bi-whatsapp"></i></div>
                            <div>
                                <div class="contact-label">WhatsApp</div>
                                <a href="https://wa.me/242044714707" target="_blank" rel="noopener" class="contact-value">Écrire sur WhatsApp</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <div class="contact-label">Pointe-Noire</div>
                                <span class="contact-value" style="font-size:.82rem;font-weight:500;">N°29 Avenue du Caire, quartier Foucks</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <div class="contact-label">Brazzaville</div>
                                <span class="contact-value" style="font-size:.82rem;font-weight:500;">Vers Saint Exupéry, en face du CFAI, quartier Bacongo</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card" data-aos="fade-left" data-aos-delay="150">
                        <div class="info-card-title">Horaires d'ouverture</div>
                        <div class="hours-grid">
                            <div class="hour-row"><span class="hour-day">Lundi – Vendredi</span><span class="hour-badge">09h – 19h</span></div>
                            <div class="hour-row"><span class="hour-day">Samedi</span><span class="hour-badge">10h – 16h</span></div>
                            <div class="hour-row"><span class="hour-day">Dimanche</span><span class="hour-badge closed">Fermé</span></div>
                        </div>
                    </div>

                    <div class="promo-card" data-aos="fade-left" data-aos-delay="200">
                        <div class="promo-icon"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="promo-title">Réponse sous 24h garantie</div>
                            <div class="promo-sub">Du lundi au vendredi, notre équipe vous répond rapidement.</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

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
                <button class="btn btn-footer-pill mt-3">VOTRE PARTENAIRE D'ÉTUDES</button>
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

/* ── 6. Inscription AJAX ── */
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

/* ── 7. Ouverture automatique modals ── */
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