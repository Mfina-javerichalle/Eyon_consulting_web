{{--
|==========================================================================
| home.blade.php — Page d'accueil Elyon Consulting
|==========================================================================
| Corrections responsive :
| - html/body overflow-x:hidden pour bloquer le scroll horizontal
| - Hero fixé : min-height:100svh, padding-top correct
| - Menu burger style offcanvas (comme image de référence)
| - Services mobile : liste simple sans grille complexe
| - Fermeture menu au clic sur overlay
| - Tous les éléments bornés à 100vw max
|==========================================================================
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elyon Consulting — Accompagnement visa étudiant, touristique et professionnel pour étudier en France et à l'étranger.">
    <title>Elyon Consulting — Votre Partenaire Études à l'Étranger</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        /* ==========================================================
           VARIABLES CSS
        ========================================================== */
        :root {
            --primary:       #0a2463;
            --primary-mid:   #0056A8;
            --primary-light: #1e40af;
            --accent:        #f0a500;
            --accent-light:  #fbbf24;
            --dark:          #07152b;
            --text:          #1e293b;
            --muted:         #64748b;
            --light-bg:      #f8fafc;
            --white:         #ffffff;
            --border:        #e2e8f0;
            --success:       #10b981;
            --font-display:  'Playfair Display', serif;
            --font-body:     'DM Sans', sans-serif;
            --radius:        16px;
            --shadow:        0 10px 40px rgba(10,36,99,0.10);
            --shadow-lg:     0 20px 60px rgba(10,36,99,0.15);
            --topbar-h:      72px;
        }

        /* ==========================================================
           RESET & BASE — CRITIQUE : empêche le scroll horizontal
        ========================================================== */
        *, *::before, *::after { box-sizing: border-box; }
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;   /* ← bloque le scroll horizontal sur html */
            max-width: 100%;
        }
        body {
            font-family: var(--font-body);
            color: var(--text);
            background: var(--white);
            overflow-x: hidden;   /* ← bloque le scroll horizontal sur body */
            max-width: 100%;
            position: relative;
        }
        img, svg, video { max-width: 100%; height: auto; display: block; }

        /* Tout élément doit rester dans la largeur */
        .container, .container-fluid { max-width: 100%; }

        /* ==========================================================
           NAVBAR DESKTOP
        ========================================================== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
        }

        .navbar {
            height: 90px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            padding: 0 1rem;
        }
        /* Hauteur identique sur mobile — comme image 2 */
        @media (max-width: 991.98px) {
            .navbar { height: 90px; }
        }

        .navbar-collapse { justify-content: center; }

        .navbar-nav .nav-item .nav-link {
            font-size: 15px;
            color: rgb(80,80,80);
            transition: color 0.3s;
            padding: 0.5rem 0.75rem;
        }
        .navbar-nav .nav-item .nav-link:hover { color: var(--primary-mid); }

        .navbar-brand img {
            height: 62px;
            width: auto;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }

       .logo-text-container {
         display: flex;
         align-items: center;
        }
        @media (min-width: 992px) {
          .logo-text-container {
             margin-left: 40px;
           }
        }        
        .logo-text-wrapper { margin-left: 10px; }
        .logo-text {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }
        .logo-subtext { font-size: 12.5px; color: rgb(90,90,90); font-weight: 400; margin-top: 2px; }

        .contact-btn {
            background-color: var(--primary);
            color: #fff !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 7px 16px;
            font-size: 14px;
            transition: background 0.2s;
            white-space: nowrap;
        }
        .contact-btn:hover { background-color: var(--primary-mid); }

        .whatsapp-link {
            display: flex;
            align-items: center;
            font-weight: 500;
            color: var(--primary) !important;
            text-decoration: none;
            white-space: nowrap;
        }
        .whatsapp-link:hover { opacity: 0.8; }
        .whatsapp-number { margin-left: 6px; font-size: 0.88rem; }

        /* Burger button */
        .navbar-toggler {
            border: none;
            padding: 4px 8px;
            background: none;
        }
        .navbar-toggler:focus { box-shadow: none; outline: none; }

        /* Cacher le menu desktop collapse sur mobile — remplacé par offcanvas */
        @media (max-width: 991.98px) {
            #navbarDesktop { display: none !important; }
        }

        /* ==========================================================
           DROPDOWN SERVICES — DESKTOP UNIQUEMENT
        ========================================================== */
        .services-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: min(750px, 95vw);
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,123,255,0.15);
            border: 1px solid #e3f2fd;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            z-index: 1060;
            margin-top: 10px;
            overflow: hidden;
        }
        .services-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-5px);
        }
        .dropdown-content { padding: 25px; }
        .dropdown-header { text-align: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #e3f2fd; }
        .dropdown-header h3 { font-family: var(--font-display); color: var(--primary); font-size: 1.3rem; font-weight: 700; margin-bottom: 6px; }
        .dropdown-header p { color: #64748b; margin: 0; font-size: 0.9rem; }

        .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
        .service-item { text-align: center; }
        .service-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; color: white; font-size: 1.15rem; }
        .service-item h5 { color: var(--primary); font-size: 0.92rem; font-weight: 600; margin-bottom: 8px; }
        .service-item ul { list-style: none; padding: 0; margin: 0; font-size: 0.82rem; color: #64748b; }
        .service-item li { padding: 2px 0; }
        .service-item li::before { content: "✓"; color: #28a745; font-weight: bold; margin-right: 4px; }

        .dropdown-footer { padding-top: 16px; border-top: 2px solid #e3f2fd; }
        .dropdown-footer .btn { background: linear-gradient(135deg,#007bff,var(--primary)); border: none; border-radius: 8px; font-weight: 600; padding: 10px 20px; color: white; }

        /* ==========================================================
           MENU MOBILE — Panneau latéral redesigné (fond sombre)
        ========================================================== */

        /* Overlay sombre avec blur */
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(7,21,43,0.65);
            z-index: 2000;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            cursor: pointer;
            transition: opacity 0.3s ease;
        }
        .mobile-overlay.active { display: block; }

        /* Panneau latéral */
        .mobile-menu {
            position: fixed;
            top: 0; right: 0;
            width: min(340px, 90vw);
            height: 100dvh;
            background: linear-gradient(180deg, #0d1f3c 0%, var(--dark) 100%);
            z-index: 2100;
            transform: translateX(110%);
            transition: transform 0.38s cubic-bezier(0.4,0,0.2,1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overscroll-behavior: contain;
            box-shadow: -16px 0 60px rgba(0,0,0,0.45);
        }
        .mobile-menu.open { transform: translateX(0); }

        /* En-tête menu */
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }
        .mobile-menu-logo { display: flex; align-items: center; gap: 0.8rem; }
        .mobile-menu-logo img {
            height: 52px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.35);
        }
        .mobile-menu-logo .brand-name {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }
        .mobile-menu-logo .brand-sub {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.45);
            margin-top: 2px;
        }

        /* Bouton fermer */
        .mobile-close-btn {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: rgba(255,255,255,0.75);
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .mobile-close-btn:hover { background: rgba(255,255,255,0.14); color: #fff; transform: rotate(90deg); }

        /* Corps du menu */
        .mobile-menu-body { padding: 0.4rem 0; flex: 1; }

        /* Titre de section */
        .mobile-section-title {
            font-size: 0.63rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 1rem 1.5rem 0.3rem;
        }

        /* Lien principal */
        .mobile-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1.5rem;
            font-size: 0.94rem;
            font-weight: 500;
            color: rgba(255,255,255,0.72);
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .mobile-nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
            padding-left: 1.75rem;
        }
        .mobile-nav-link.active { color: var(--accent-light); }

        .mobile-nav-link .link-left {
            display: flex; align-items: center; gap: 0.75rem;
        }
        .mobile-nav-link .link-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .mobile-nav-link:hover .link-icon,
        .mobile-nav-link.active .link-icon {
            background: rgba(240,165,0,0.15);
            border-color: rgba(240,165,0,0.25);
            color: var(--accent-light);
        }
        .mobile-nav-link .chevron {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.25);
            transition: transform 0.28s ease;
            flex-shrink: 0;
        }
        .mobile-nav-link.open .chevron {
            transform: rotate(90deg);
            color: var(--accent-light);
        }

        /* Sous-menu services */
        .mobile-submenu {
            display: none;
            background: rgba(0,0,0,0.18);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .mobile-submenu.open { display: block; }

        .mobile-submenu-cat {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 0.75rem 1.5rem 0.25rem;
        }
        .mobile-submenu-link {
            display: flex; align-items: center; gap: 0.55rem;
            padding: 0.6rem 1.5rem 0.6rem 1.75rem;
            font-size: 0.87rem;
            color: rgba(255,255,255,0.58);
            text-decoration: none;
            transition: all 0.15s;
        }
        .mobile-submenu-link::before {
            content: "";
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--accent);
            opacity: 0.55;
            flex-shrink: 0;
        }
        .mobile-submenu-link:hover {
            color: rgba(255,255,255,0.9);
            background: rgba(255,255,255,0.04);
            padding-left: 2rem;
        }
        .mobile-submenu-link:hover::before { opacity: 1; }

        .mobile-submenu-all {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            font-size: 0.87rem;
            font-weight: 700;
            color: var(--accent-light);
            text-decoration: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin-top: 0.2rem;
            transition: color 0.2s;
        }
        .mobile-submenu-all:hover { color: white; }

        /* Liens auth */
        .mobile-nav-link.auth-login .link-icon  { background:rgba(30,64,175,.2); border-color:rgba(30,64,175,.3); color:#93c5fd; }
        .mobile-nav-link.auth-register .link-icon { background:rgba(16,185,129,.15); border-color:rgba(16,185,129,.25); color:#6ee7b7; }
        .mobile-nav-link.auth-logout { color:rgba(252,165,165,.75); }
        .mobile-nav-link.auth-logout .link-icon { background:rgba(239,68,68,.12); border-color:rgba(239,68,68,.2); color:#fca5a5; }
        .mobile-nav-link.auth-logout:hover { color:#fca5a5; }

        /* Pied du menu */
        .mobile-menu-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            background: rgba(0,0,0,0.15);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .btn-mobile-contact {
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
            width: 100%;
            padding: 0.9rem 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(10,36,99,0.35);
        }
        .btn-mobile-contact:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(10,36,99,.45); color:white; }

        .btn-mobile-whatsapp {
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
            width: 100%;
            padding: 0.9rem 1rem;
            background: rgba(37,211,102,0.1);
            color: #4ade80;
            border: 1px solid rgba(37,211,102,0.22);
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s;
        }
        .btn-mobile-whatsapp:hover { background:rgba(37,211,102,.18); color:#86efac; }


       /* ==========================================================
   HERO — FIXÉ pour ne pas déborder + espaces latéraux
========================================================== */
.hero {
    min-height: 100svh;
    padding-top: calc(90px + 2rem);
    padding-bottom: 3rem;
    padding-left: 2.5rem;
    padding-right: 2.5rem;
    background: linear-gradient(135deg, #ffffff 0%, #eff6ff 50%, #dbeafe 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    width: 100%;
}

/* Si tu as un .container Bootstrap à l'intérieur */
.hero .container,
.hero .container-fluid,
.hero .container-xl {
    padding-left: 2.5rem;
    padding-right: 2.5rem;
}

@media (min-width: 1200px) {
    .hero .container,
    .hero .container-fluid,
    .hero .container-xl {
        padding-left: 3rem;
        padding-right: 3rem;
    }
}

@media (max-width: 768px) {
    .hero {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
    .hero .container,
    .hero .container-fluid,
    .hero .container-xl {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
}

.hero::before {
    content: "";
    position: absolute;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(10,36,99,0.07) 0%, transparent 70%);
    top: -200px; right: -200px;
    border-radius: 50%;
    pointer-events: none;
}
.hero::after {
    content: "";
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(240,165,0,0.06) 0%, transparent 70%);
    bottom: -150px; left: -150px;
    border-radius: 50%;
    pointer-events: none;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    padding: 0.45rem 1.1rem;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 16px rgba(10,36,99,0.22);
}

.hero-title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 7vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    color: var(--primary);
    margin-bottom: 1.25rem;
}
.hero-title .highlight { color: var(--accent); }

.hero-lead {
    font-size: clamp(0.95rem, 2.5vw, 1.1rem);
    color: var(--muted);
    line-height: 1.75;
    margin-bottom: 2rem;
}

.btn-hero-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white !important;
    border: none;
    border-radius: 999px;
    padding: 0.85rem 2rem;
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(10,36,99,0.25);
}
.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(10,36,99,0.35);
}

.btn-hero-secondary {
    background: transparent;
    color: var(--primary) !important;
    border: 2px solid rgba(10,36,99,0.25);
    border-radius: 999px;
    padding: 0.8rem 1.75rem;
    font-size: 0.92rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}
.btn-hero-secondary:hover {
    background: rgba(10,36,99,0.06);
    border-color: var(--primary);
    transform: translateY(-2px);
}

.hero-stats {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}
.hero-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 0.85rem 1.25rem;
    box-shadow: 0 4px 12px rgba(10,36,99,0.07);
    min-width: 90px;
}
.hero-stat .number {
    font-family: var(--font-display);
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
}
.hero-stat .label {
    font-size: 0.72rem;
    color: var(--muted);
    font-weight: 500;
    text-align: center;
    margin-top: 0.2rem;
}

.hero-visual-card {
    background: white;
    border-radius: 22px;
    padding: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
}
.hero-icon-circle {
    width: 100px; height: 100px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    border: 3px solid #bfdbfe;
}
.hero-icon-circle i {
    font-size: 2.5rem;
    color: var(--primary-light);
}

.hero-feature-list { list-style: none; padding: 0; margin: 0; }
.hero-feature-list li {
    display: flex; align-items: center; gap: 0.65rem;
    padding: 0.6rem 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--text);
}
.hero-feature-list li:last-child { border-bottom: none; }
.hero-feature-list i { color: var(--success); font-size: 0.95rem; flex-shrink: 0; }
/* ==========================================================
   FIX GLOBAL — espaces latéraux sur tous les containers
========================================================== */
.services-section .container,
.process-section .container,
.about-section .container,
.cta-section .container,
.elyon-footer .container,
.elyon-footer .container-fluid {
    padding-left: 2.5rem;
    padding-right: 2.5rem;
}

@media (min-width: 1200px) {
    .services-section .container,
    .process-section .container,
    .about-section .container,
    .cta-section .container,
    .elyon-footer .container,
    .elyon-footer .container-fluid {
        padding-left: 3rem;
        padding-right: 3rem;
    }
}

@media (max-width: 768px) {
    .services-section .container,
    .process-section .container,
    .about-section .container,
    .cta-section .container,
    .elyon-footer .container,
    .elyon-footer .container-fluid {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
}

/* ==========================================================
   SECTION SERVICES
========================================================== */
.services-section { padding: 5rem 0; background: var(--light-bg); }

.section-badge {
    display: inline-block;
    background: rgba(10,36,99,0.08);
    color: var(--primary-light);
    padding: 0.35rem 1rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}
.section-title-main {
    font-family: var(--font-display);
    font-size: clamp(1.6rem, 4vw, 2.4rem);
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
    margin-bottom: 0.75rem;
}
.section-subtitle { font-size: 1rem; color: var(--muted); max-width: 520px; margin: 0 auto; }

.service-preview-card {
    background: white;
    border-radius: 18px;
    padding: 1.75rem;
    border: 1px solid var(--border);
    box-shadow: 0 4px 14px rgba(10,36,99,0.06);
    height: 100%;
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
    color: inherit;
}
.service-preview-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: rgba(30,64,175,0.2); }

.service-card-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.1rem;
    box-shadow: 0 4px 14px rgba(10,36,99,0.2);
}
.service-card-icon i { font-size: 1.4rem; color: white; }
.service-card-title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; }
.service-card-text { font-size: 0.88rem; color: var(--muted); line-height: 1.6; }

/* ==========================================================
   PROCESSUS
========================================================== */
.process-section { padding: 5rem 0; background: white; }
.process-step { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem 1rem; }
.process-number {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-display);
    font-size: 1.3rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    box-shadow: 0 6px 20px rgba(10,36,99,0.22);
    flex-shrink: 0;
}
.process-step h4 { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--primary); margin-bottom: 0.4rem; }
.process-step p { font-size: 0.86rem; color: var(--muted); line-height: 1.6; margin: 0; }

/* ==========================================================
   À PROPOS
========================================================== */
.about-section { padding: 5rem 0; background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%); color: white; }
.about-section .section-badge { background: rgba(240,165,0,0.15); color: var(--accent-light); border: 1px solid rgba(240,165,0,0.3); }
.about-section .section-title-main { color: white; }

.about-stat-card { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: var(--radius); padding: 1.25rem; text-align: center; backdrop-filter: blur(10px); transition: all 0.3s ease; }
.about-stat-card:hover { background: rgba(255,255,255,0.14); transform: translateY(-3px); }
.about-stat-number { font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--accent); display: block; line-height: 1; margin-bottom: 0.3rem; }
.about-stat-label { font-size: 0.82rem; color: rgba(255,255,255,0.7); font-weight: 500; }

.about-feature { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.1rem; }
.about-feature-icon { width: 42px; height: 42px; background: rgba(240,165,0,0.15); border: 1px solid rgba(240,165,0,0.3); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.about-feature-icon i { color: var(--accent); font-size: 1.05rem; }
.about-feature h5 { font-size: 0.92rem; font-weight: 700; color: white; margin-bottom: 0.2rem; }
.about-feature p { font-size: 0.83rem; color: rgba(255,255,255,0.65); margin: 0; }

/* ==========================================================
   CTA
========================================================== */
.cta-section { padding: 5rem 0; background: var(--light-bg); }
.cta-card {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 24px;
    padding: 3.5rem 2.5rem;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}
.cta-card::before { content: ""; position: absolute; width: 350px; height: 350px; background: rgba(255,255,255,0.05); border-radius: 50%; top: -180px; right: -120px; pointer-events: none; }
.cta-card h2 { font-family: var(--font-display); font-size: clamp(1.6rem, 4vw, 2.3rem); font-weight: 800; margin-bottom: 0.85rem; }
.cta-card p { font-size: 1rem; color: rgba(255,255,255,0.8); margin-bottom: 2rem; }

.btn-cta-white { background: white; color: var(--primary) !important; border: none; border-radius: 999px; padding: 0.9rem 2rem; font-size: 0.95rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.14); }
.btn-cta-white:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.2); }
.btn-cta-outline { background: transparent; color: white !important; border: 2px solid rgba(255,255,255,0.4); border-radius: 999px; padding: 0.85rem 1.75rem; font-size: 0.92rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; }
.btn-cta-outline:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.7); }

/* ==========================================================
   MODALS
========================================================== */
.modal { z-index: 9999; }
.modal-content {
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.08);
    background: radial-gradient(circle at top left, #1e3a8a 0%, #071529 50%, #040712 100%);
    color: #f5f7ff;
    box-shadow: 0 24px 60px rgba(0,0,0,0.55);
    overflow: hidden;
}
.modal-header { border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1.5rem 1.75rem 1rem; }
.modal-title { font-family: var(--font-display); font-weight: 700; font-size: 1.1rem; color: var(--accent-light); }
.modal-header .btn-close { filter: invert(1) grayscale(1); }
.modal-body { padding: 1rem 1.75rem 1.75rem; }
.modal-body .form-label { font-size: 0.83rem; font-weight: 600; color: rgba(220,228,255,0.9); margin-bottom: 0.4rem; }
.modal-body .form-control { background: rgba(5,16,40,0.85); border-radius: 10px; border: 1px solid rgba(100,120,200,0.5); color: #f5f7ff; font-size: 0.9rem; padding: 0.65rem 0.9rem; }
.modal-body .form-control:focus { background: rgba(5,18,46,0.95); border-color: #497eff; box-shadow: 0 0 0 0.2rem rgba(73,132,255,0.2); }
.modal-body .form-control::placeholder { color: rgba(180,192,220,0.5); }
.btn-modal-primary { border-radius: 999px; padding: 0.7rem 1rem; font-weight: 700; font-size: 0.9rem; background: linear-gradient(135deg,#497eff,#23b3ff); border: none; transition: all 0.3s ease; }
.btn-modal-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(73,132,255,0.4); }
.btn-modal-success { border-radius: 999px; padding: 0.7rem 1rem; font-weight: 700; font-size: 0.9rem; background: linear-gradient(135deg,#10b981,#059669); border: none; transition: all 0.3s ease; }
.btn-modal-success:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,185,129,0.4); }
.modal-footer-link { color: rgba(180,200,255,0.7); font-size: 0.82rem; text-align: center; margin-top: 1rem; }
.modal-footer-link a { color: var(--accent-light); text-decoration: none; font-weight: 600; }

/* ==========================================================
   FOOTER
========================================================== */
.elyon-footer { background: #07152b; position: relative; overflow: hidden; }
.elyon-footer::before { content: ""; position: absolute; top: -40px; left: 0; right: 0; height: 40px; background: #07152b; border-top-left-radius: 50% 100%; border-top-right-radius: 50% 100%; }
.elyon-logo-placeholder { width: 60px; height: 60px; border-radius: 16px; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #1a315c; font-weight: 700; font-size: 16px; flex-shrink: 0; }
.footer-subtitle { font-size: 0.78rem; letter-spacing: 0.15em; text-transform: uppercase; color: #f0a23a; }
.footer-title { font-size: 0.82rem; letter-spacing: 0.18em; text-transform: uppercase; color: #f0a23a; margin-bottom: 1rem; }
.footer-links a { color: #e3e7f2; font-size: 0.88rem; text-decoration: none; display: block; margin-bottom: 6px; }
.footer-links a:hover { color: #ffffff; }
.btn-footer-pill { border-radius: 999px; background: #173a6d; color: #ffffff; border: none; font-size: 0.78rem; padding: 0.5rem 1.4rem; }
.elyon-footer .icon-circle { background: #122543; color: #f0a23a; border-radius: 10px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.btn-footer-contact { border-radius: 999px; background: #1f57a8; color: #ffffff; border: none; font-weight: 600; padding: 0.65rem 1.1rem; }
.btn-footer-contact:hover { background: #1a488d; color: #fff; }
.social-icon { width: 46px; height: 46px; border-radius: 12px; background: #122543; display: flex; align-items: center; justify-content: center; color: #ffffff; text-decoration: none; transition: background 0.2s; }
.social-icon:hover { background: #1f57a8; color: #fff; }
.elyon-footer p { font-size: 0.88rem; }
        /* ==========================================================
           RESPONSIVE CORRECTIONS
        ========================================================== */
        @media (max-width: 575.98px) {
            /* Hero */
            .hero { padding-top: calc(var(--topbar-h) + 1.5rem); padding-bottom: 2rem; }
            .hero-stats { gap: 0.6rem; }
            .hero-stat { min-width: 80px; padding: 0.7rem 0.9rem; }
            .hero-stat .number { font-size: 1.3rem; }

            /* Boutons héro empilés */
            .hero .d-flex.flex-wrap { flex-direction: column; align-items: stretch; }
            .btn-hero-primary, .btn-hero-secondary { justify-content: center; }

            /* CTA */
            .cta-card { padding: 2.5rem 1.5rem; }
            .cta-card .d-flex { flex-direction: column; align-items: stretch; }
            .btn-cta-white, .btn-cta-outline { justify-content: center; }

            /* Footer */
            .elyon-footer .row .col-6 { flex: 0 0 100%; max-width: 100%; }
        }

        @media (max-width: 767.98px) {
            /* Masquer la partie visuelle hero sur très petit écran */
            .hero-visual-card { display: none; }
            .col-lg-6:last-child { display: none; }
        }

        /* ==========================================================
           NAVBAR SCROLL SHRINK
        ========================================================== */
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.12); }
    </style>
</head>
<body>

{{-- ================================================================
     OVERLAY MOBILE MENU
================================================================ --}}
<div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>

{{-- ================================================================
     MENU MOBILE 
================================================================ --}}
<nav class="mobile-menu" id="mobileMenu" aria-label="Menu mobile" aria-hidden="true">


    {{-- En-tête --}}
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

    {{-- Corps --}}
    <div class="mobile-menu-body">

        <div class="mobile-section-title">Navigation</div>

        <a href="{{ route('home') }}" class="mobile-nav-link active">
            <span class="link-left">
                <span class="link-icon"><i class="bi bi-house-fill"></i></span>
                Accueil
            </span>
        </a>

        <a href="{{ route('home') }}#about-section" class="mobile-nav-link" onclick="closeMobileMenu()">
            <span class="link-left">
                <span class="link-icon"><i class="bi bi-info-circle-fill"></i></span>
                À propos
            </span>
        </a>

        {{-- Services avec sous-menu accordéon --}}
        <div class="mobile-nav-link" id="servicesToggle" onclick="toggleServicesSubmenu(event)">
            <span class="link-left">
                <span class="link-icon"><i class="bi bi-briefcase-fill"></i></span>
                Nos services
            </span>
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

        <a href="{{ route('contact') }}" class="mobile-nav-link" onclick="closeMobileMenu()">
            <span class="link-left">
                <span class="link-icon"><i class="bi bi-envelope-fill"></i></span>
                Contact
            </span>
        </a>

        <div class="mobile-section-title">Mon compte</div>

        @auth
            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'client.dashboard') }}"
               class="mobile-nav-link" onclick="closeMobileMenu()">
                <span class="link-left">
                    <span class="link-icon"><i class="bi bi-person-circle"></i></span>
                    Mon espace
                </span>
            </a>
            <div class="mobile-nav-link auth-logout"
                 onclick="document.getElementById('logout-nav-form').submit();">
                <span class="link-left">
                    <span class="link-icon"><i class="bi bi-box-arrow-right"></i></span>
                    Déconnexion
                </span>
            </div>
        @else
            <div class="mobile-nav-link auth-login"
                 onclick="closeMobileMenu(); setTimeout(()=>new bootstrap.Modal(document.getElementById('loginModal')).show(),200);">
                <span class="link-left">
                    <span class="link-icon"><i class="bi bi-box-arrow-in-right"></i></span>
                    Connexion
                </span>
            </div>
            <div class="mobile-nav-link auth-register"
                 onclick="closeMobileMenu(); setTimeout(()=>new bootstrap.Modal(document.getElementById('registerModal')).show(),200);">
                <span class="link-left">
                    <span class="link-icon"><i class="bi bi-person-plus-fill"></i></span>
                    Inscription gratuite
                </span>
            </div>
        @endauth

    </div>

    {{-- Pied --}}
    <div class="mobile-menu-footer">
        <a href="{{ route('contact') }}" class="btn-mobile-contact" onclick="closeMobileMenu()">
            <i class="bi bi-send-fill"></i> Nous contacter
        </a>
        <a href="https://wa.me/242044714707" target="_blank" rel="noopener" class="btn-mobile-whatsapp">
            <i class="bi bi-whatsapp fs-5"></i> +242 04 471 47 07
        </a>
    </div>

</nav>

{{-- ================================================================
     NAVBAR PRINCIPALE
================================================================ --}}
<header data-aos="fade-down">
    <nav class="navbar navbar-expand-lg navbar-light bg-white" id="mainNavbar">
        <div class="container">

            {{-- Logo --}}
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="logo-text-container">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Elyon Consulting">
                    <div class="logo-text-wrapper">
                        <div class="logo-text">Elyon Consulting</div>
                        <div class="logo-subtext">Accompagnement voyage</div>
                    </div>
                </div>
            </a>

            {{-- Burger mobile — ouvre l'offcanvas personnalisé --}}
            <button class="navbar-toggler d-lg-none" type="button"
                    onclick="openMobileMenu()"
                    aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navigation desktop uniquement --}}
            <div id="navbarDesktop" class="collapse navbar-collapse d-lg-flex">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#about-section">À propos</a>
                    </li>
                    {{-- Dropdown services desktop --}}
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
                                <div class="services-grid">
                                    <div class="service-item">
                                        <div class="service-icon" style="background:linear-gradient(135deg,#007bff,#004080);"><i class="bi bi-globe"></i></div>
                                        <h5>Destinations</h5>
                                        <ul>
                                            <li>France – Études</li>
                                            <li>Canada – Tourisme</li>
                                            <li>Belgique – Études</li>
                                            <li>Luxembourg – Études</li>
                                            <li>USA – Tourisme</li>
                                        </ul>
                                    </div>
                                    <div class="service-item">
                                        <div class="service-icon" style="background:linear-gradient(135deg,#28a745,#1e7e34);"><i class="bi bi-check-circle"></i></div>
                                        <h5>Accompagnement</h5>
                                        <ul>
                                            <li>Visa & Dossier</li>
                                            <li>Billets avion</li>
                                            <li>Logement</li>
                                            <li>Blocage de fond</li>
                                            <li>Installation</li>
                                        </ul>
                                    </div>
                                    <div class="service-item">
                                        <div class="service-icon" style="background:linear-gradient(135deg,#17a2b8,#117a8b);"><i class="bi bi-star"></i></div>
                                        <h5>Expertise</h5>
                                        <ul>
                                            <li>Orientation études</li>
                                            <li>Entretien visa</li>
                                            <li>Installation</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dropdown-footer">
                                    <a href="{{ route('services.index') }}" class="btn btn-primary w-100 text-white">
                                        Voir tous les services <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                {{-- Actions droite --}}
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a href="{{ route('contact') }}" class="btn contact-btn">
                            <i class="bi bi-send-fill me-1"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link whatsapp-link" href="https://wa.me/242044714707" target="_blank" rel="noopener">
                            <i class="bi bi-whatsapp fs-5"></i>
                            <span class="whatsapp-number">+242 04 471 47 07</span>
                        </a>
                    </li>
                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/avatar.png') }}"
                                     class="rounded-circle border"
                                     style="width:34px;height:34px;object-fit:cover;"
                                     alt="Avatar" id="navbarAvatar">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard Admin</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('client.dashboard') }}"><i class="bi bi-person-circle me-2 text-primary"></i> Mon espace</a></li>
                                @endif
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                       onclick="document.getElementById('logout-nav-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                    </a>
                                </li>
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

{{-- ================================================================
     MODALS — Connexion & Inscription
================================================================ --}}
@guest
    <span class="d-none" data-bs-toggle="modal" data-bs-target="#loginModal"></span>
@endguest

{{-- MODAL CONNEXION --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-arrow-in-right me-2"></i>Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(session('login_error'))
                    <div class="alert alert-danger py-2 mb-3 rounded-3" style="font-size:0.83rem;">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ session('login_error') }}<br>
                        <a href="#" class="text-danger fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" style="font-size:0.82rem;">
                            <i class="bi bi-key me-1"></i> Réinitialiser mon mot de passe
                        </a>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success py-2 mb-3 rounded-3" style="font-size:0.83rem;">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-2">
                        <input type="email" name="email" placeholder="Email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <input type="password" name="password" placeholder="Mot de passe"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="text-end mb-3">
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal"
                           style="font-size:.8rem;color:rgba(180,200,255,.7);text-decoration:none;">
                            Mot de passe oublié ?
                        </a>
                    </div>
                    <button type="submit" class="btn btn-modal-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                    </button>
                </form>
                <p class="modal-footer-link mt-3">Pas encore de compte ? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">S'inscrire gratuitement</a></p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL MOT DE PASSE OUBLIÉ --}}
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-key me-2"></i>Mot de passe oublié</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(session('reset_success'))
                    <div class="alert alert-success py-2 mb-3 rounded-3" style="font-size:.83rem;"><i class="bi bi-check-circle me-1"></i> {{ session('reset_success') }}</div>
                @endif
                @if(session('reset_error'))
                    <div class="alert alert-danger py-2 mb-3 rounded-3" style="font-size:.83rem;"><i class="bi bi-exclamation-circle me-1"></i> {{ session('reset_error') }}</div>
                @endif
                <p style="color:rgba(220,228,255,.8);font-size:.85rem;margin-bottom:1.25rem;">
                    <i class="bi bi-info-circle me-1"></i> Entrez votre adresse email pour recevoir un lien de réinitialisation.
                </p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="votre@email.com" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-modal-primary w-100">
                        <i class="bi bi-send me-2"></i> Envoyer le lien
                    </button>
                </form>
                <p class="modal-footer-link mt-3">Vous vous souvenez ? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INSCRIPTION --}}
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Créer un compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="registerMessage"></div>
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="name" class="form-control" placeholder="Jean Dupont" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" class="form-control" placeholder="votre@email.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone <span style="color:rgba(180,200,255,.5);font-size:.78rem;">(optionnel)</span></label>
                        <input type="text" name="telephone" class="form-control" placeholder="+242 06 000 00 00" value="{{ old('telephone') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 8 caractères" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Répétez votre mot de passe" required>
                    </div>
                    <input type="hidden" name="role" value="client">
                    <button type="submit" class="btn btn-modal-success w-100">
                        <i class="bi bi-person-check me-2"></i> Créer mon compte
                    </button>
                </form>
                <p class="modal-footer-link mt-3">Déjà un compte ? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     HERO
================================================================ --}}
<section class="hero" id="hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <div data-aos="fade-up" data-aos-duration="800">
                    <span class="hero-badge"><i class="bi bi-star-fill"></i> N°1 Accompagnement Mobilité</span>
                </div>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                    Votre visa,<br>notre <span class="highlight">expertise</span>
                </h1>
                <p class="hero-lead" data-aos="fade-up" data-aos-delay="200">
                    Elyon Consulting vous accompagne de A à Z dans vos démarches de
                    mobilité internationale — visa étudiant, touristique ou professionnel.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('services.index') }}" class="btn-hero-primary">
                        <i class="bi bi-compass"></i> Nos services
                    </a>
                    <a href="{{ route('contact') }}" class="btn-hero-secondary">
                        <i class="bi bi-telephone"></i> Nous contacter
                    </a>
                </div>
                <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                    <div class="hero-stat"><span class="number">500+</span><span class="label">Étudiants accompagnés</span></div>
                    <div class="hero-stat"><span class="number">98%</span><span class="label">Visas obtenus</span></div>
                    <div class="hero-stat"><span class="number">15 ans</span><span class="label">D'expertise</span></div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-visual-card">
                    <div class="hero-icon-circle">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h4 style="font-family:var(--font-display);text-align:center;color:var(--primary);margin-bottom:1.25rem;">
                        Pourquoi choisir Elyon ?
                    </h4>
                    <ul class="hero-feature-list">
                        <li><i class="bi bi-check-circle-fill"></i> Accompagnement personnalisé de A à Z</li>
                        <li><i class="bi bi-check-circle-fill"></i> Suivi numérique de votre dossier en temps réel</li>
                        <li><i class="bi bi-check-circle-fill"></i> Taux de succès visa de 98 %</li>
                        <li><i class="bi bi-check-circle-fill"></i> Support WhatsApp disponible 7j/7</li>
                        <li><i class="bi bi-check-circle-fill"></i> Équipe expérimentée : 15 ans d'expertise</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     SERVICES
================================================================ --}}
<section class="services-section" id="services-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Nos services</span>
            <h2 class="section-title-main">Destinations & Visas</h2>
            <p class="section-subtitle">Découvrez nos offres d'accompagnement pour étudier ou voyager à l'étranger</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <a href="{{ route('services.index') }}" class="service-preview-card">
                    <div class="service-card-icon"><i class="bi bi-mortarboard-fill"></i></div>
                    <div class="service-card-title">Visa Étudiant</div>
                    <p class="service-card-text">Orientation universitaire, dossier Campus France, logement étudiant. Nous gérons toute la procédure pour votre admission en France.</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('services.index') }}" class="service-preview-card">
                    <div class="service-card-icon"><i class="bi bi-airplane-fill"></i></div>
                    <div class="service-card-title">Visa Touristique</div>
                    <p class="service-card-text">Planification de votre voyage, réservations, constitution de dossier Schengen. Voyagez l'esprit tranquille.</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mx-md-auto mx-lg-0" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('services.index') }}" class="service-preview-card">
                    <div class="service-card-icon"><i class="bi bi-briefcase-fill"></i></div>
                    <div class="service-card-title">Visa Professionnel</div>
                    <p class="service-card-text">Démarches pour les visas de travail, détachement ou contrat international. Expertise et rigueur administratives.</p>
                </a>
            </div>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('services.index') }}" class="btn-hero-primary">
                <i class="bi bi-grid-3x3-gap-fill"></i> Voir toutes nos destinations
            </a>
        </div>
    </div>
</section>

{{-- ================================================================
     PROCESSUS
================================================================ --}}
<section class="process-section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Comment ça marche</span>
            <h2 class="section-title-main">4 étapes vers votre visa</h2>
            <p class="section-subtitle">Un processus simple, transparent et guidé à chaque étape</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="process-step">
                    <div class="process-number">01</div>
                    <div><h4>Inscription</h4><p>Créez votre compte client et accédez à votre espace personnel sécurisé.</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="process-step">
                    <div class="process-number">02</div>
                    <div><h4>Choisir un service</h4><p>Sélectionnez le type de visa et la destination qui correspond à votre projet.</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="process-step">
                    <div class="process-number">03</div>
                    <div><h4>Déposer vos documents</h4><p>Uploadez vos pièces justificatives directement depuis votre espace client.</p></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="process-step">
                    <div class="process-number">04</div>
                    <div><h4>Suivi en temps réel</h4><p>Suivez l'avancement de votre dossier et recevez les mises à jour instantanément.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     À PROPOS
================================================================ --}}
<section class="about-section" id="about-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="section-badge">Qui sommes-nous ?</span>
                <h2 class="section-title-main mb-3">Elyon Consulting</h2>
                <p style="color:rgba(255,255,255,.75);font-size:1rem;line-height:1.75;margin-bottom:2rem;">
                    Spécialistes depuis 15 ans dans l'accompagnement des personnes souhaitant voyager ou étudier à l'étranger. Nous gérons l'intégralité du processus de constitution et de suivi de vos dossiers.
                </p>
                <div class="row g-3">
                    <div class="col-6"><div class="about-stat-card"><span class="about-stat-number">500+</span><span class="about-stat-label">Étudiants accompagnés</span></div></div>
                    <div class="col-6"><div class="about-stat-card"><span class="about-stat-number">98%</span><span class="about-stat-label">Taux de succès visa</span></div></div>
                    <div class="col-6"><div class="about-stat-card"><span class="about-stat-number">50+</span><span class="about-stat-label">Universités partenaires</span></div></div>
                    <div class="col-6"><div class="about-stat-card"><span class="about-stat-number">15 ans</span><span class="about-stat-label">D'expertise</span></div></div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="about-feature">
                    <div class="about-feature-icon"><i class="bi bi-shield"></i></div>
                    <div><h5>Sécurité & Fiabilité</h5><p>Vos documents sont stockés de façon sécurisée et confidentiels. Nous respectons scrupuleusement les réglementations RGPD.</p></div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon"><i class="bi bi-headset"></i></div>
                    <div><h5>Support 7j/7</h5><p>Notre équipe est disponible via WhatsApp, téléphone et email pour répondre à toutes vos questions rapidement.</p></div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon"><i class="bi bi-laptop"></i></div>
                    <div><h5>Plateforme digitale</h5><p>Gérez votre dossier en ligne, uploadez vos documents et suivez votre avancement depuis n'importe quel appareil.</p></div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div><h5>Présence locale</h5><p>Deux agences physiques à Pointe-Noire et Brazzaville pour vous accueillir et vous accompagner en personne.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CTA
================================================================ --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-card" data-aos="zoom-in">
            <h2>Prêt à commencer votre aventure ?</h2>
            <p>Créez votre compte gratuit et déposez votre premier dossier en quelques minutes.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="#" class="btn-cta-white" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="bi bi-person-plus"></i> Créer un compte gratuit
                </a>
                <a href="{{ route('contact') }}" class="btn-cta-outline">
                    <i class="bi bi-telephone"></i> Parler à un conseiller
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     FOOTER
================================================================ --}}
<footer class="elyon-footer text-white pt-5 pb-4">
    <div class="container">
        <div class="row align-items-start g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="d-flex align-items-center mb-3 gap-3">
                    <div class="elyon-logo-placeholder">EC</div>
                    <div>
                        <h3 class="mb-1 fw-bold" style="font-size:clamp(.95rem,2.5vw,1.3rem);">ELYON CONSULTING</h3>
                        <p class="mb-0 footer-subtitle">CONSEIL & ACCOMPAGNEMENT</p>
                    </div>
                </div>
                <p class="small mb-2">ELYON CONSULTING, le premier pas pour étudier en France.</p>
                <button class="btn btn-footer-pill mt-3">VOTRE PARTENAIRE D'ÉTUDES EN FRANCE</button>
            </div>
            <div class="col-lg-2 col-md-6 col-6" data-aos="fade-up" data-aos-delay="150">
                <h6 class="footer-title">NAVIGATION</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('services.index') }}">Nos services</a></li>
                    <li><a href="{{ route('home') }}#about-section">À propos</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h6 class="footer-title">ADRESSE POINTE-NOIRE</h6>
                <div class="d-flex mb-3 gap-3">
                    <div class="icon-circle"><i class="bi bi-geo-alt"></i></div>
                    <p class="mb-0 small">N°29 Avenue du Caire, quartier Foucks<br>Réf : Église Saint François d'Assise</p>
                </div>
                <div class="d-flex mb-2 gap-3">
                    <div class="icon-circle"><i class="bi bi-telephone"></i></div>
                    <div>
                        <p class="mb-0 small">+242 06 827 74 01</p>
                        <p class="mb-0 small">+242 05 345 93 57</p>
                        <p class="mb-0 small">+242 04 471 47 07</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="250">
                <h6 class="footer-title">ADRESSE BRAZZAVILLE</h6>
                <div class="d-flex mb-3 gap-3">
                    <div class="icon-circle"><i class="bi bi-geo-alt"></i></div>
                    <p class="mb-0 small">Vers Saint Exupéry, en face du CFAI,<br>quartier Bacongo</p>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-footer-contact w-100">
                    <span class="me-2">➤</span> Nous contacter
                </a>
            </div>
        </div>
        <div class="row mt-4 align-items-center" data-aos="fade-up" data-aos-delay="300">
            <div class="col-lg-6 col-md-6">
                <p class="small mb-2">SUIVEZ-NOUS</p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 text-md-end mt-3 mt-md-0">
                <p class="small mb-0" style="color:rgba(255,255,255,.28);">© {{ date('Y') }} Elyon Consulting — Tous droits réservés</p>
            </div>
        </div>
    </div>
</footer>

{{-- ================================================================
     SCRIPTS
================================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
/* ── 1. AOS ── */
AOS.init({ duration:800, once:true, offset:60, easing:'ease-out-cubic' });

/* ── 2. Navbar ombre au scroll ── */
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 30);
});

/* ── 3. MENU MOBILE — Ouverture / Fermeture ── */
function openMobileMenu() {
    document.getElementById('mobileMenu').classList.add('open');
    document.getElementById('mobileOverlay').classList.add('active');
    document.getElementById('mobileMenu').setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden'; // empêche le scroll du body
}

function closeMobileMenu() {
    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('mobileOverlay').classList.remove('active');
    document.getElementById('mobileMenu').setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
}

/* Fermeture avec la touche Escape */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeMobileMenu();
});

/* ── 4. SOUS-MENU SERVICES dans le menu mobile ── */
function toggleServicesSubmenu(e) {
    e.preventDefault();
    const toggle  = document.getElementById('servicesToggle');
    const submenu = document.getElementById('servicesSubmenu');
    const isOpen  = submenu.classList.toggle('open');
    toggle.classList.toggle('open', isOpen);
}

/* ── 5. DROPDOWN SERVICES — DESKTOP uniquement ── */
(function() {
    const navItem  = document.querySelector('#navbarDesktop .nav-item.position-relative');
    const dropdown = document.getElementById('servicesDropdown');
    const arrow    = document.getElementById('servicesArrow');
    if (!navItem || !dropdown) return;

    function openDD()  { dropdown.classList.add('show');    if(arrow) arrow.style.transform = 'rotate(180deg)'; }
    function closeDD() { dropdown.classList.remove('show'); if(arrow) arrow.style.transform = 'rotate(0deg)'; }

    navItem.addEventListener('mouseenter', openDD);
    navItem.addEventListener('mouseleave', closeDD);
})();

/* ── 6. INSCRIPTION AJAX ── */
$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $('#registerMessage').html('');
        $.ajax({
            url: "{{ route('register') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#registerMessage').html(
                    '<div class="alert alert-success py-2 rounded-3" style="font-size:.83rem;">' +
                    '<i class="bi bi-check-circle me-1"></i> Inscription réussie ! ' +
                    '<a href="#" class="text-warning" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a>' +
                    '</div>'
                );
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

/* ── 7. Ouverture automatique des modals selon session ── */
@if(session('open_forgot_modal'))
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('forgotPasswordModal')).show();
    });
@endif
@if(session('open_login_modal') || session('login_error') || session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('loginModal')).show();
    });
@endif
@if($errors->has('email') && session('reset_error'))
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('forgotPasswordModal')).show();
    });
@endif
</script>
</body>
</html>