{{--
|==========================================================================
| home.blade.php — Page d'accueil Elyon Consulting
|==========================================================================
| Vue principale publique.
| Sections : Navbar · Hero · Services · À propos · Contact · Footer
| Animations : AOS (Animate On Scroll)
| Design : Professionnel, bleu marine & or, Bootstrap 5
|==========================================================================
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elyon Consulting — Accompagnement visa étudiant, touristique et professionnel pour étudier en France et à l'étranger.">
    <title>Elyon Consulting — Votre Partenaire Études à l'Étranger</title>

    {{-- ===== CDN CSS ===== --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">


    <style>
        /* ==========================================================
           VARIABLES CSS — Palette cohérente sur toutes les pages
        ========================================================== */
        :root {
            --primary:       #0a2463;   /* Bleu marine profond */
            --primary-mid: #0056A8;
            --primary-light: #1e40af;   /* Bleu medium */
            --accent:        #f0a500;   /* Or / ambre */
            --accent-light:  #fbbf24;   /* Or clair */
            --dark:          #07152b;   /* Fond footer */
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
        }

        /* ==========================================================
           RESET & BASE
        ========================================================== */
        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            color: var(--text);
            background: var(--white);
            overflow-x: hidden;
        }

              /* ==============================================
           2. NAVBAR
        ============================================== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        #loginModal{
            position: fixed;
            z-index: 9999;
        }

         #registerModal{
            position: fixed;
            z-index: 9999;
        }

        .navbar {
            height: 100px;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.09);
        }

        .navbar-collapse {
            justify-content: center;
        }

        .navbar-nav .nav-item .nav-link {
            font-size: 16px;
            color: rgb(99, 99, 99);
            text-align: center;
            transition: color 0.3s;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: var(--primary-mid);
        }

        /* Logo */
        .navbar-brand img {
            height: 60px;
            width: auto;
            border-radius: 9px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
        }

        .logo-text-container {
            display: flex;
            align-items: center;
        }

        .logo-text-wrapper {
            margin-left: 10px;
        }

        .logo-text {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .logo-subtext {
            font-size: 12px;
            color: rgb(99, 99, 99);
            font-weight: 400;
            margin-top: 2px;
        }

        /* Bouton contact navbar */
        .contact-btn {
            background-color: var(--primary);
            color: #fff !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 8px 18px;
            transition: background 0.2s;
        }

        .contact-btn:hover {
            background-color: var(--primary-mid);
        }

        /* WhatsApp */
        .whatsapp-link {
            display: flex;
            align-items: center;
            font-weight: 500;
            color: var(--primary) !important;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .whatsapp-link:hover {
            opacity: 0.8;
        }

        .whatsapp-number {
            margin-left: 6px;
            font-size: 0.9rem;
        }


        

        /* ==============================================
           3. DROPDOWN SERVICES
        ============================================== */
        .services-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 750px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
            border: 1px solid #e3f2fd;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            margin-top: 10px;
            overflow: hidden;
        }

        .services-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-5px);
        }

        .dropdown-content {
            padding: 25px;
        }

        .dropdown-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e3f2fd;
        }

        .dropdown-header h3 {
            font-family: var(--font-display);
            color: #1e3a8a;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .dropdown-header p {
            color: #64748b;
            margin: 0;
            font-size: 0.95rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .service-item {
            text-align: center;
        }

        .service-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: white;
            font-size: 1.2rem;
        }

        .service-item h5 {
            color: #1e3a8a;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .service-item ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.4;
        }

        .service-item li {
            padding: 2px 0;
        }

        .service-item li::before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            margin-right: 5px;
        }

        .dropdown-footer {
            padding-top: 20px;
            border-top: 2px solid #e3f2fd;
        }

        .dropdown-footer .btn {
            background: linear-gradient(135deg, #007bff, var(--primary));
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 12px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
        }
        /* ==========================================================
           HERO SECTION — Gradient + image de fond
        ========================================================== */
        .hero {
            min-height: 125vh;
            padding-top: 80px; /* compense navbar fixe */
            background:
                linear-gradient(135deg, #ffffff 0%, #eff6ff 50%, #dbeafe 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        /* Cercles décoratifs */
        .hero::before {
            content: "";
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(10,36,99,0.07) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(240,165,0,0.06) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            border-radius: 50%;
            pointer-events: none;
        }

        /* Badge au-dessus du titre */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 20px rgba(10,36,99,0.25);
        }

        /* Titre principal */
        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.6rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.08;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .hero-title .highlight {
            color: var(--accent);
            position: relative;
        }

        /* Sous-titre */
        .hero-lead {
            font-size: 1.15rem;
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 2.5rem;
            max-width: 520px;
        }

        /* Boutons CTA hero */
        .btn-hero-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white !important;
            border: none;
            border-radius: 999px;
            padding: 1rem 2.25rem;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 8px 24px rgba(10,36,99,0.28);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(10,36,99,0.38);
        }

        .btn-hero-secondary {
            background: transparent;
            color: var(--primary) !important;
            border: 2px solid rgba(10,36,99,0.25);
            border-radius: 999px;
            padding: 0.95rem 2rem;
            font-size: 0.95rem;
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

        /* Stats flottantes hero */
        .hero-stats {
            display: flex;
            gap: 1.5rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .hero-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 16px rgba(10,36,99,0.07);
            min-width: 110px;
        }

        .hero-stat .number {
            font-family: var(--font-display);
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .hero-stat .label {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 500;
            text-align: center;
            margin-top: 0.2rem;
        }

        /* Illustration côté droit */
        .hero-visual-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
        }

        .hero-icon-circle {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 3px solid #bfdbfe;
        }

        .hero-icon-circle i {
            font-size: 3rem;
            color: var(--primary-light);
        }

        .hero-feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .hero-feature-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text);
        }

        .hero-feature-list li:last-child { border-bottom: none; }

        .hero-feature-list i {
            color: var(--success);
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* ==========================================================
           SECTION SERVICES APERÇU
        ========================================================== */
        .services-section {
            padding: 6rem 0;
            background: var(--light-bg);
        }

        /* Badge de section */
        .section-badge {
            display: inline-block;
            background: rgba(10,36,99,0.08);
            color: var(--primary-light);
            padding: 0.4rem 1.1rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-title-main {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .section-subtitle {
            font-size: 1.05rem;
            color: var(--muted);
            max-width: 520px;
            margin: 0 auto;
        }

        /* Card service */
        .service-preview-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: 0 4px 16px rgba(10,36,99,0.06);
            height: 100%;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .service-preview-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(30,64,175,0.25);
        }

        .service-card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 6px 18px rgba(10,36,99,0.22);
        }

        .service-card-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .service-card-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .service-card-text {
            font-size: 0.9rem;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ==========================================================
           SECTION PROCESSUS — Comment ça marche
        ========================================================== */
        .process-section {
            padding: 6rem 0;
            background: white;
        }

        .process-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .process-number {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 24px rgba(10,36,99,0.25);
        }

        .process-step h4 {
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .process-step p {
            font-size: 0.88rem;
            color: var(--muted);
            line-height: 1.6;
            margin: 0;
        }

        /* Ligne de connexion entre étapes */
        .process-connector {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            position: absolute;
            top: 32px;
            right: -30px;
        }

        /* ==========================================================
           SECTION À PROPOS
        ========================================================== */
        .about-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            color: white;
        }

        .about-section .section-badge {
            background: rgba(240,165,0,0.15);
            color: var(--accent-light);
            border: 1px solid rgba(240,165,0,0.3);
        }

        .about-section .section-title-main {
            color: white;
        }

        .about-stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .about-stat-card:hover {
            background: rgba(255,255,255,0.14);
            transform: translateY(-4px);
        }

        .about-stat-number {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--accent);
            display: block;
            line-height: 1;
            margin-bottom: 0.35rem;
        }

        .about-stat-label {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .about-feature-icon {
            width: 44px;
            height: 44px;
            background: rgba(240,165,0,0.15);
            border: 1px solid rgba(240,165,0,0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .about-feature-icon i {
            color: var(--accent);
            font-size: 1.1rem;
        }

        .about-feature h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.2rem;
        }

        .about-feature p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.65);
            margin: 0;
        }

        /* ==========================================================
           SECTION CTA (Appel à l'action)
        ========================================================== */
        .cta-section {
            padding: 6rem 0;
            background: var(--light-bg);
        }

        .cta-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 28px;
            padding: 4rem 3rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .cta-card::before {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -200px;
            right: -150px;
        }

        .cta-card h2 {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-card p {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.8);
            margin-bottom: 2.5rem;
        }

        .btn-cta-white {
            background: white;
            color: var(--primary) !important;
            border: none;
            border-radius: 999px;
            padding: 1rem 2.25rem;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .btn-cta-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.2);
        }

        .btn-cta-outline {
            background: transparent;
            color: white !important;
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 999px;
            padding: 0.95rem 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-cta-outline:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.7);
        }

        /* ==========================================================
           MODALS CONNEXION / INSCRIPTION — Style dark prestige
        ========================================================== */
        .modal-content {
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.08);
            background: radial-gradient(circle at top left, #1e3a8a 0%, #071529 50%, #040712 100%);
            color: #f5f7ff;
            box-shadow: 0 24px 60px rgba(0,0,0,0.55);
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 1.5rem 1.75rem 1rem;
        }

        .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--accent-light);
        }

        .modal-header .btn-close {
            filter: invert(1) grayscale(1);
        }

        .modal-body { padding: 1rem 1.75rem 1.75rem; }

        .modal-body .form-label {
            font-size: 0.83rem;
            font-weight: 600;
            color: rgba(220,228,255,0.9);
            margin-bottom: 0.4rem;
        }

        .modal-body .form-control {
            background: rgba(5,16,40,0.85);
            border-radius: 10px;
            border: 1px solid rgba(100,120,200,0.5);
            color: #f5f7ff;
            font-size: 0.9rem;
            padding: 0.65rem 0.9rem;
        }

        .modal-body .form-control:focus {
            background: rgba(5,18,46,0.95);
            border-color: #497eff;
            box-shadow: 0 0 0 0.2rem rgba(73,132,255,0.2);
        }

        .modal-body .form-control::placeholder { color: rgba(180,192,220,0.5); }

        .btn-modal-primary {
            border-radius: 999px;
            padding: 0.7rem 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            background: linear-gradient(135deg, #497eff, #23b3ff);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-modal-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(73,132,255,0.4);
        }

        .btn-modal-success {
            border-radius: 999px;
            padding: 0.7rem 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-modal-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(16,185,129,0.4);
        }

        .modal-footer-link {
            color: rgba(180,200,255,0.7);
            font-size: 0.82rem;
            text-align: center;
            margin-top: 1rem;
        }

        .modal-footer-link a {
            color: var(--accent-light);
            text-decoration: none;
            font-weight: 600;
        }

         /* ==============================================
           8. FOOTER
        ============================================== */
        .elyon-footer {
            background: #07152b;
            position: relative;
        }

        .elyon-footer::before {
            content: "";
            position: absolute;
            top: -40px;
            left: 0;
            right: 0;
            height: 40px;
            background: #07152b;
            border-top-left-radius: 50% 100%;
            border-top-right-radius: 50% 100%;
        }

        .elyon-logo-placeholder {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a315c;
            font-weight: 700;
            font-size: 18px;
        }

        .footer-subtitle {
            font-size: 0.8rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #f0a23a;
        }

        .footer-title {
            font-size: 0.85rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #f0a23a;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #e3e7f2;
            font-size: 0.9rem;
            text-decoration: none;
            display: block;
            margin-bottom: 6px;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .btn-footer-pill {
            border-radius: 999px;
            background: #173a6d;
            color: #ffffff;
            border: none;
            font-size: 0.8rem;
            padding: 0.55rem 1.6rem;
        }

        /* icon-circle footer (override couleur sombre) */
        .elyon-footer .icon-circle {
            background: #122543;
            color: #f0a23a;
            border-radius: 12px;
        }

        .btn-footer-contact {
            border-radius: 999px;
            background: #1f57a8;
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 0.7rem 1.2rem;
        }

        .btn-footer-contact:hover {
            background: #1a488d;
            color: #fff;
        }

        .social-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #122543;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-decoration: none;
            transition: background 0.2s;
        }

        .social-icon:hover {
            background: #1f57a8;
            color: #fff;
        }

        .elyon-footer p {
            font-size: 0.9rem;
        }

        /* ==========================================================
           RESPONSIVE
        ========================================================== */
        @media (max-width: 991px) {
            .ec-navbar { height: auto; min-height: 70px; }
            .hero-stats { justify-content: center; }
            .hero { text-align: center; }
            .hero-lead { max-width: 100%; margin: 0 auto 2rem; }
            .hero-badge { margin-left: auto; margin-right: auto; }
        }

        @media (max-width: 768px) {
            .hero { padding: 90px 0 3rem; }
            .hero-title { font-size: 2.4rem; }
            .ec-footer::before { display: none; }
            .cta-card { padding: 2.5rem 1.5rem; }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2rem; }
            .hero-stat { min-width: 90px; }
            .brand-name { font-size: 0.9rem; }
        }
    </style>
</head>
<body>

    {{-- ================================================================
         NAVBAR — Barre de navigation principale
    ================================================================ --}}
    <header data-aos="fade-down">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
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

                {{-- Bouton burger mobile --}}
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Menu --}}
                <div class="collapse navbar-collapse" id="navbarNav">

                    {{-- Liens principaux (centrés) --}}
                    <ul class="navbar-nav mx-auto text-center">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                        </li>

                        {{-- Lien ancre vers la section À propos sur la page d'accueil --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#about-section">À propos</a>
                        </li>

                        {{-- Services avec dropdown hover --}}
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="{{ route('services.index') }}">Nos services</a>

                            <div class="services-dropdown" id="servicesDropdown">
                                <div class="dropdown-content">

                                    <div class="dropdown-header">
                                        <h3><i class="bi bi-briefcase"></i> Nos Services</h3>
                                        <p>Solutions complètes pour vos projets voyage & études</p>
                                    </div>

                                    <div class="services-grid">

                                        <div class="service-item">
                                            <div class="service-icon" style="background: linear-gradient(135deg, #007bff, #004080);">
                                                <i class="bi bi-globe"></i>
                                            </div>
                                            <h5>Destinations</h5>
                                            <ul>
                                                <li>France - Études</li>
                                                <li>Canada - Tourisme</li>
                                                <li>Belgique - Études</li>
                                                <li>Luxembourg - Études</li>
                                                <li>USA - Tourisme</li>
                                            </ul>
                                        </div>

                                        <div class="service-item">
                                            <div class="service-icon" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                                                <i class="bi bi-check-circle"></i>
                                            </div>
                                            <h5>Accompagnement</h5>
                                            <ul>
                                                <li>Visa & Dossier</li>
                                                <li>Billets avion</li>
                                                <li>Logement</li>
                                                <li>Blocage de fond financier</li>
                                                <li>Assistance installation</li>
                                            </ul>
                                        </div>

                                        <div class="service-item">
                                            <div class="service-icon" style="background: linear-gradient(135deg, #17a2b8, #117a8b);">
                                                <i class="bi bi-star"></i>
                                            </div>
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
                                            Voir tous les services
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </li>

                    </ul>

                    {{-- Actions côté droit --}}
                    <ul class="navbar-nav ms-auto align-items-center">

                        <li class="nav-item me-3">
                            <a href="{{ route('contact') }}" class="btn contact-btn">
                                <i class="bi bi-send-fill me-1"></i> Contact
                            </a>
                        </li>

                        <li class="nav-item me-3">
                            <a class="nav-link whatsapp-link" href="https://wa.me/242044714707" target="_blank" rel="noopener">
                                <i class="bi bi-whatsapp fs-5"></i>
                                <span class="whatsapp-number">+242 04 471 47 07</span>
                            </a>
                        </li>

                                   @auth
                    <div class="dropdown user-dropdown">
                        <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('images/avatar.png') }}"
                                 class="rounded-circle border"
                                 style="width:36px;height:36px;object-fit:cover;" alt="Avatar">
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
                    <div class="dropdown user-dropdown">
                        <a href="#" data-bs-toggle="dropdown" style="color:var(--text); text-decoration:none;">
                            <i class="bi bi-person-circle" style="font-size:1.6rem;"></i>
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
         MENU MOBILE (Offcanvas)
    ================================================================ --}}
    <div class="offcanvas offcanvas-end" id="mobileMenu" style="max-width: 300px;">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="height:36px; border-radius:8px;">
                <span style="font-family: var(--font-display); font-weight: 700; color: var(--primary);">Elyon Consulting</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="d-flex flex-column gap-1">
                <a class="nav-link-ec" href="{{ route('home') }}"><i class="bi bi-house me-2"></i>Accueil</a>
                <a class="nav-link-ec" href="{{ route('services.index') }}"><i class="bi bi-briefcase me-2"></i>Nos services</a>
                <a class="nav-link-ec" href="#about-section" data-bs-dismiss="offcanvas"><i class="bi bi-info-circle me-2"></i>À propos</a>
                <a class="nav-link-ec" href="{{ route('contact') }}"><i class="bi bi-envelope me-2"></i>Contact</a>
                <hr>
                @auth
                    <a class="nav-link-ec" href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'client.dashboard') }}">
                        <i class="bi bi-person-circle me-2"></i>Mon espace
                    </a>
                @else
                    <a class="nav-link-ec text-primary" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                    </a>
                    <a class="nav-link-ec text-success" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">
                        <i class="bi bi-person-plus me-2"></i>Inscription
                    </a>
                @endauth
            </nav>
        </div>
    </div>

    {{-- ================================================================
         MODALS — Connexion & Inscription
    ================================================================ --}}

    {{-- ----- MODAL CONNEXION ----- --}}
   <!-- Toujours visible pour les guests -->
@guest
    <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
        Connexion
    </button>
@endguest

{{-- ----- MODAL CONNEXION ----- --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-arrow-in-right me-2"></i>Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Message d'erreur de connexion --}}
                @if(session('login_error'))
                    <div class="alert alert-danger py-2 mb-3 rounded-3" style="font-size:0.83rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        {{ session('login_error') }}
                        {{-- Lien mot de passe oublié dans le message d'erreur --}}
                        <br>
                        <a href="#" class="text-danger fw-bold"
                           data-bs-dismiss="modal"
                           data-bs-toggle="modal"
                           data-bs-target="#forgotPasswordModal"
                           style="font-size:0.82rem;">
                            <i class="bi bi-key me-1"></i> Réinitialiser mon mot de passe
                        </a>
                    </div>
                @endif

                {{-- Message de succès --}}
                @if(session('success'))
                    <div class="alert alert-success py-2 mb-3 rounded-3" style="font-size:0.83rem;">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-2">
                        <input type="email"
                               name="email"
                               placeholder="Email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-2">
                        <input type="password"
                               name="password"
                               placeholder="Mot de passe"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                            <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lien mot de passe oublié --}}
                    <div class="text-end mb-3">
                        <a href="#"
                           data-bs-dismiss="modal"
                           data-bs-toggle="modal"
                           data-bs-target="#forgotPasswordModal"
                           style="font-size:0.8rem; color:rgba(180,200,255,0.7); text-decoration:none;">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-modal-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                    </button>
                </form>

                <p class="modal-footer-link mt-3">
                    Pas encore de compte ?
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                        S'inscrire gratuitement
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ----- MODAL MOT DE PASSE OUBLIÉ ----- --}}
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-key me-2"></i>Mot de passe oublié</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Message succès envoi email --}}
                @if(session('reset_success'))
                    <div class="alert alert-success py-2 mb-3 rounded-3" style="font-size:0.83rem;">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('reset_success') }}
                    </div>
                @endif

                {{-- Message erreur --}}
                @if(session('reset_error'))
                    <div class="alert alert-danger py-2 mb-3 rounded-3" style="font-size:0.83rem;">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        {{ session('reset_error') }}
                    </div>
                @endif

                <p style="color:rgba(220,228,255,0.8); font-size:0.85rem; margin-bottom:1.25rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="votre@email.com"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback" style="font-size:0.78rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-modal-primary w-100">
                        <i class="bi bi-send me-2"></i> Envoyer le lien de réinitialisation
                    </button>
                </form>

                <p class="modal-footer-link mt-3">
                    Vous vous souvenez de votre mot de passe ?
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
{{-- ----- MODAL INSCRIPTION ----- --}}
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Créer un compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Message après inscription --}}
                <div id="registerMessage"></div>

                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nom --}}
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Jean Dupont"
                               value="{{ old('name') }}"
                               required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="votre@email.com"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    {{-- Téléphone --}}
                    <div class="mb-3">
                        <label class="form-label">Téléphone <span style="color:rgba(180,200,255,0.5); font-size:0.78rem;">(optionnel)</span></label>
                        <input type="text"
                               name="telephone"
                               class="form-control"
                               placeholder="+242 06 000 00 00"
                               value="{{ old('telephone') }}">
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Minimum 8 caractères"
                               required>
                    </div>

                    {{-- Confirmation --}}
                    <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Répétez votre mot de passe"
                               required>
                    </div>

                    {{-- Rôle caché — toujours client à l'inscription --}}
                    <input type="hidden" name="role" value="client">

                    <button type="submit" class="btn btn-modal-success w-100">
                        <i class="bi bi-person-check me-2"></i> Créer mon compte
                    </button>
                </form>

                <p class="modal-footer-link mt-3">
                    Déjà un compte ?
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

    {{-- ================================================================
         SECTION HERO — Première section visible
    ================================================================ --}}
    <section class="hero" id="hero">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- Contenu texte --}}
                <div class="col-lg-6">
                    <div data-aos="fade-up" data-aos-duration="800">
                        <span class="hero-badge">
                            <i class="bi bi-star-fill"></i> N°1 Accompagnement Mobilité
                        </span>
                    </div>

                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                        Votre visa,<br>
                        notre <span class="highlight">expertise</span>
                    </h1>

                    <p class="hero-lead" data-aos="fade-up" data-aos-delay="200">
                        Elyon Consulting vous accompagne de A à Z dans vos démarches de
                        mobilité internationale — visa étudiant, touristique ou professionnel.
                    </p>

                    {{-- Boutons CTA --}}
                    <div class="d-flex flex-wrap gap-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('services.index') }}" class="btn-hero-primary">
                            <i class="bi bi-compass"></i> Nos services
                        </a>
                        <a href="{{ route('contact') }}" class="btn-hero-secondary">
                            <i class="bi bi-telephone"></i> Nous contacter
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="hero-stat">
                            <span class="number">500+</span>
                            <span class="label">Étudiants accompagnés</span>
                        </div>
                        <div class="hero-stat">
                            <span class="number">98%</span>
                            <span class="label">Visas obtenus</span>
                        </div>
                        <div class="hero-stat">
                            <span class="number">15 ans</span>
                            <span class="label">D'expertise</span>
                        </div>
                    </div>
                </div>

                {{-- Illustration --}}
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="hero-visual-card">
                        <div class="hero-icon-circle">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <h4 style="font-family: var(--font-display); text-align:center; color: var(--primary); margin-bottom:1.5rem;">
                            Pourquoi choisir Elyon ?
                        </h4>
                        <ul class="hero-feature-list">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Accompagnement personnalisé de A à Z
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Suivi numérique de votre dossier en temps réel
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Taux de succès visa de 98 %
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Support WhatsApp disponible 7j/7
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Équipe expérimentée : 15 ans d'expertise
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section> 

    {{-- ================================================================
         SECTION SERVICES APERÇU
    ================================================================ --}}
    <section class="services-section" id="services-section">
        <div class="container">

            {{-- En-tête --}}
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">Nos services</span>
                <h2 class="section-title-main">Destinations & Visas</h2>
                <p class="section-subtitle">
                    Découvrez nos offres d'accompagnement pour étudier ou voyager à l'étranger
                </p>
            </div>

            {{-- Grille de cards --}}
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                    <a href="{{ route('services.index') }}" class="service-preview-card">
                        <div class="service-card-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div class="service-card-title">Visa Étudiant</div>
                        <p class="service-card-text">
                            Orientation universitaire, dossier Campus France, logement étudiant.
                            Nous gérons toute la procédure pour votre admission en France.
                        </p>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ route('services.index') }}" class="service-preview-card">
                        <div class="service-card-icon">
                            <i class="bi bi-airplane-fill"></i>
                        </div>
                        <div class="service-card-title">Visa Touristique</div>
                        <p class="service-card-text">
                            Planification de votre voyage, réservations, constitution de dossier Schengen.
                            Voyagez l'esprit tranquille.
                        </p>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('services.index') }}" class="service-preview-card">
                        <div class="service-card-icon">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div class="service-card-title">Visa Professionnel</div>
                        <p class="service-card-text">
                            Démarches pour les visas de travail, détachement ou contrat international.
                            Expertise et rigueur administratives.
                        </p>
                    </a>
                </div>
            </div>

            {{-- Bouton voir tous les services --}}
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('services.index') }}" class="btn-hero-primary">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    Voir toutes nos destinations
                </a>
            </div>
        </div>
    </section>

    {{-- ================================================================
         SECTION PROCESSUS — Comment ça marche
    ================================================================ --}}
    <section class="process-section">
        <div class="container">

            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-badge">Comment ça marche</span>
                <h2 class="section-title-main">4 étapes vers votre visa</h2>
                <p class="section-subtitle">
                    Un processus simple, transparent et guidé à chaque étape
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                {{-- Étape 1 --}}
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="process-step">
                        <div class="process-number">01</div>
                        <h4>Inscription</h4>
                        <p>Créez votre compte client et accédez à votre espace personnel sécurisé.</p>
                    </div>
                </div>

                {{-- Étape 2 --}}
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="process-step">
                        <div class="process-number">02</div>
                        <h4>Choisir un service</h4>
                        <p>Sélectionnez le type de visa et la destination qui correspond à votre projet.</p>
                    </div>
                </div>

                {{-- Étape 3 --}}
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="process-step">
                        <div class="process-number">03</div>
                        <h4>Déposer vos documents</h4>
                        <p>Uploadez vos pièces justificatives directement depuis votre espace client.</p>
                    </div>
                </div>

                {{-- Étape 4 --}}
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="process-step">
                        <div class="process-number">04</div>
                        <h4>Suivi en temps réel</h4>
                        <p>Suivez l'avancement de votre dossier et recevez les mises à jour instantanément.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         SECTION À PROPOS — Sur fond sombre
    ================================================================ --}}
    <section class="about-section" id="about-section">
        <div class="container">
            <div class="row g-5 align-items-center">

                {{-- Statistiques --}}
                <div class="col-lg-5" data-aos="fade-right">
                    <span class="section-badge">Qui sommes-nous ?</span>
                    <h2 class="section-title-main mb-3">Elyon Consulting</h2>
                    <p style="color: rgba(255,255,255,0.75); font-size:1rem; line-height:1.75; margin-bottom:2rem;">
                        Spécialistes depuis 15 ans dans l'accompagnement des personnes souhaitant
                        voyager ou étudier à l'étranger. Nous gérons l'intégralité du processus
                        de constitution et de suivi de vos dossiers.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="about-stat-card">
                                <span class="about-stat-number">500+</span>
                                <span class="about-stat-label">Étudiants accompagnés</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-stat-card">
                                <span class="about-stat-number">98%</span>
                                <span class="about-stat-label">Taux de succès visa</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-stat-card">
                                <span class="about-stat-number">50+</span>
                                <span class="about-stat-label">Universités partenaires</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-stat-card">
                                <span class="about-stat-number">15 ans</span>
                                <span class="about-stat-label">D'expertise</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Features --}}
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="about-feature">
                        <div class="about-feature-icon"><i class="bi bi-shield-check-fill"></i></div>
                        <div>
                            <h5>Sécurité & Fiabilité</h5>
                            <p>Vos documents sont stockés de façon sécurisée et confidentiels. Nous respectons scrupuleusement les réglementations RGPD.</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon"><i class="bi bi-headset"></i></div>
                        <div>
                            <h5>Support 7j/7</h5>
                            <p>Notre équipe est disponible via WhatsApp, téléphone et email pour répondre à toutes vos questions rapidement.</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon"><i class="bi bi-laptop"></i></div>
                        <div>
                            <h5>Plateforme digitale</h5>
                            <p>Gérez votre dossier en ligne, uploadez vos documents et suivez votre avancement depuis n'importe quel appareil.</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <h5>Présence locale</h5>
                            <p>Deux agences physiques à Pointe-Noire et Brazzaville pour vous accueillir et vous accompagner en personne.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================
         SECTION CTA — Appel à l'action final
    ================================================================ --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-card" data-aos="zoom-in">
                <h2>Prêt à commencer votre aventure ?</h2>
                <p>Créez votre compte gratuit et déposez votre premier dossier en quelques minutes.</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="#" class="btn-cta-white"
                       data-bs-toggle="modal" data-bs-target="#registerModal">
                        <i class="bi bi-person-plus"></i> Créer un compte gratuit
                    </a>
                    <a href="{{ route('contact') }}" class="btn-cta-outline">
                        <i class="bi bi-telephone"></i> Parler à un conseiller
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- =============================================
         FOOTER
    ============================================= --}}
    <footer class="elyon-footer text-white pt-5 pb-4">
        <div class="container">

            <div class="row align-items-start">

                {{-- Logo + slogan --}}
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="elyon-logo me-3">
                            <span class="elyon-logo-placeholder">EC</span>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">ELYON CONSULTING</h3>
                            <p class="mb-0 footer-subtitle">CONSEIL & ACCOMPAGNEMENT</p>
                        </div>
                    </div>
                    <p class="small mb-2">ELYON CONSULTING, le premier pas pour étudier en France.</p>
                    <button class="btn btn-footer-pill mt-3">VOTRE PARTENAIRE D'ÉTUDES EN FRANCE</button>
                </div>

                {{-- Navigation --}}
                <div class="col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="150">
                    <h6 class="footer-title">NAVIGATION</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('services.index') }}">Nos services</a></li>
                        <li><a href="{{ route('home') }}#about-section">À propos</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                {{-- Adresse Pointe-Noire --}}
                <div class="col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h6 class="footer-title">ADRESSE POINTE-NOIRE</h6>

                    <div class="d-flex mb-3">
                        <div class="icon-circle me-3">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <p class="mb-0 small">
                            N°29 Avenue du Caire, quartier Foucks<br>
                            Réf : Église Saint François d'Assise, en allant vers l'école Fonkoma
                        </p>
                    </div>

                    <div class="d-flex mb-2">
                        <div class="icon-circle me-3">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <p class="mb-0 small">+242 06 827 74 01</p>
                            <p class="mb-0 small">+242 05 345 93 57</p>
                            <p class="mb-0 small">+242 04 471 47 07</p>
                        </div>
                    </div>

                    <div class="d-flex mt-3">
                        <div class="icon-circle me-3">
                            <i class="bi bi-send"></i>
                        </div>
                        <p class="mb-0 small">@Amis vol</p>
                    </div>
                </div>

                {{-- Adresse Brazzaville --}}
                <div class="col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="250">
                    <h6 class="footer-title">ADRESSE BRAZZAVILLE</h6>

                    <div class="d-flex mb-3">
                        <div class="icon-circle me-3">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <p class="mb-0 small">
                            Vers Saint Exupéry, en face du CFAI,<br>
                            quartier Bacongo
                        </p>
                    </div>

                    <button class="btn btn-footer-contact w-100">
                        <span class="me-2">➤</span> Nous contacter
                    </button>
                </div>

            </div>

            {{-- Réseaux sociaux + copyright --}}
            <div class="row mt-4 align-items-center" data-aos="fade-up" data-aos-delay="300">
                <div class="col-lg-6">
                    <p class="small mb-2">SUIVEZ-NOUS</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                    <p class="small mb-0" style="color: rgba(255,255,255,0.28);">
                        © {{ date('Y') }} Elyon Consulting — Tous droits réservés
                    </p>
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
    /* -------------------------------------------------------
       Initialisation AOS (Animate On Scroll)
    ------------------------------------------------------- */
    AOS.init({
        duration: 800,
        once: true,
        offset: 60,
        easing: 'ease-out-cubic'
    });

    /* -------------------------------------------------------
       Navbar : ajouter une ombre au scroll
    ------------------------------------------------------- */
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('mainNavbar');
        if (navbar) {
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    /* -------------------------------------------------------
       Dropdown Services (hover)
    ------------------------------------------------------- */
    (function () {
        const navItem  = document.querySelector('.nav-item.position-relative');
        const dropdown = document.getElementById('servicesDropdown');
        if (!navItem || !dropdown) return;
        navItem.addEventListener('mouseenter', () => dropdown.classList.add('show'));
        navItem.addEventListener('mouseleave', () => dropdown.classList.remove('show'));
    })();

    /* -------------------------------------------------------
       Inscription AJAX
       Évite le rechargement de la page et affiche les erreurs
       directement dans le modal d'inscription
    ------------------------------------------------------- */
    $(document).ready(function () {
        $('#registerForm').on('submit', function (e) {
            e.preventDefault();
            $('#registerMessage').html('');

            $.ajax({
                url: "{{ route('register') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function () {
                    $('#registerMessage').html(
                        '<div class="alert alert-success py-2 rounded-3" style="font-size:0.83rem;">' +
                        '<i class="bi bi-check-circle me-1"></i> Inscription réussie ! ' +
                        '<a href="#" class="text-warning" data-bs-dismiss="modal" ' +
                        'data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a>' +
                        '</div>'
                    );
                    $('#registerForm')[0].reset();
                },
                error: function (xhr) {
                    let errors   = xhr.responseJSON.errors;
                    let html = '<div class="alert alert-danger py-2 rounded-3" style="font-size:0.83rem;"><ul class="mb-0 ps-3">';
                    $.each(errors, function (key, value) {
                        html += '<li>' + value[0] + '</li>';
                    });
                    html += '</ul></div>';
                    $('#registerMessage').html(html);
                }
            });
        });
    });

    /* -------------------------------------------------------
       Ouvrir automatiquement le modal "Mot de passe oublié"
       si la session indique qu'il faut l'afficher
    ------------------------------------------------------- */
    @if(session('open_forgot_modal'))
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
            modal.show();
        });
    @endif

    /* -------------------------------------------------------
       Ouvrir automatiquement le modal de connexion
       si la session indique qu'il faut l'afficher
       (après réinitialisation réussie par exemple)
    ------------------------------------------------------- */
    @if(session('open_login_modal') || session('login_error') || session('success'))
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        });
    @endif

    /* -------------------------------------------------------
       Ouvrir automatiquement le modal "Mot de passe oublié"
       si erreur sur le formulaire de reset (email invalide)
    ------------------------------------------------------- */
    @if($errors->has('email') && session('reset_error'))
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
            modal.show();
        });
    @endif
</script>
</body>
</html>
