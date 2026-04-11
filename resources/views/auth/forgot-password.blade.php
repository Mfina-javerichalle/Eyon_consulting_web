<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — Elyon Consulting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0a2463;
            --primary-light: #1e40af;
            --accent: #f0a500;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #0a2463 0%, #07152b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-auth {
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
        }
        .icon-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 3px solid #bfdbfe;
        }
        .icon-circle i { font-size: 1.8rem; color: var(--primary-light); }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.25s;
        }
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.2rem rgba(30,64,175,0.12);
        }
        .btn-primary-auth {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-primary-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(10,36,99,0.25);
            color: white;
        }
        .back-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }
        .back-link:hover { color: var(--primary-light); }
    </style>
</head>
<body>
    <div class="card-auth">

        {{-- Logo --}}
        <div class="text-center mb-4">
            <div class="brand-logo mb-1">Elyon Consulting</div>
            <div style="font-size:0.75rem; color:#64748b; text-transform:uppercase; letter-spacing:0.1em;">
                Réinitialisation du mot de passe
            </div>
        </div>

        {{-- Icône --}}
        <div class="icon-circle">
            <i class="bi bi-key-fill"></i>
        </div>

        {{-- Message succès --}}
        @if(session('reset_success'))
            <div class="alert alert-success rounded-3 mb-4" style="font-size:0.85rem;">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('reset_success') }}
            </div>
        @endif

        {{-- Message erreur --}}
        @if(session('reset_error'))
            <div class="alert alert-danger rounded-3 mb-4" style="font-size:0.85rem;">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('reset_error') }}
            </div>
        @endif

        <p style="color:#64748b; font-size:0.88rem; text-align:center; margin-bottom:1.5rem;">
            Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:0.85rem; color:#374151;">
                    Adresse email
                </label>
                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="votre@email.com"
                       value="{{ old('email') }}"
                       required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary-auth mb-3">
                <i class="bi bi-send me-2"></i> Envoyer le lien de réinitialisation
            </button>
        </form>

        <div class="text-center">
            <a href="{{ route('home') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Retour à l'accueil
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>