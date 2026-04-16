# 🌍 ELYON CONSULTING — Application Web

> Plateforme de gestion des démarches de mobilité internationale  
> **BTS SIO — Option SLAM — Session 2026**

🔗 **Site en production : [https://elyon-consulting.com](https://elyon-consulting.com)**

---

## 📌 Présentation du projet

ELYON Consulting est une **application web full-stack** développée dans le cadre du BTS SIO SLAM.

C'est une **plateforme réelle** permettant à une entreprise spécialisée dans la mobilité internationale de gérer les dossiers de demande de visa de ses clients (visa étudiant, touristique, de travail).

L'application remplace une gestion manuelle (e-mails, WhatsApp, papier) par un système centralisé, sécurisé et accessible depuis tout navigateur web.

---

## 🎯 Fonctionnalités principales

### Espace Client
- Inscription et connexion sécurisée (session Laravel)
- Consultation des services disponibles (visa étudiant, touristique, travail)
- Création et suivi de dossier avec étapes et statuts en temps réel
- Upload de pièces justificatives (PDF, JPEG, PNG — max 5 Mo)
- **Suppression d'un document uploadé** (si non encore validé par l'admin)
- Consultation du statut des documents (en attente / validé / refusé)
- Re-soumission d'un document refusé
- Messagerie intégrée avec l'administrateur
- **Effacement de l'historique des messages**
- Gestion du profil (nom, email, téléphone, avatar, mot de passe)
- Réinitialisation du mot de passe par email (Gmail SMTP)
- Formulaire de contact avec envoi d'email HTML formaté

### Espace Administrateur
- Tableau de bord avec statistiques (dossiers, utilisateurs, services)
- CRUD des services (ajout, modification, suppression)
- Gestion des documents requis par service
- Gestion des étapes par service
- Gestion des informations visa et des frais
- Validation / refus des documents soumis par les clients
- Mise à jour des statuts des dossiers et des étapes
- Gestion des utilisateurs (liste, activation/désactivation, suppression)
- Messagerie : répondre aux clients par dossier
- Gestion du profil admin (avatar, informations)

### API REST (pour l'application mobile)
- Authentification sécurisée via Laravel Sanctum (Bearer Token)
- Endpoints JSON pour tous les modules (services, dossiers, documents, étapes, messages)
- Documentation et tests via Postman

---

## 🛠️ Stack technique

| Couche | Technologie |
|--------|-------------|
| Backend | PHP **8.3.30**, Laravel **12.x** (MVC, Eloquent ORM) |
| Frontend | Laravel Blade, Bootstrap **5.3.2**, AOS 2.3.4, JavaScript ES6+ |
| Base de données | MySQL 8 |
| Authentification Web | Sessions Laravel |
| Authentification API | Laravel Sanctum (Bearer Token) |
| Envoi d'emails | **Gmail SMTP** (mot de passe d'application Google) |
| Stockage fichiers | `Storage::disk('public')` — symlink via `storage:link` |
| Hébergeur | **o2switch** (cPanel + SSH) — PHP 8.3 |
| Outils | GitHub, Postman, StarUML, VS Code, XAMPP |

---

## 🗄️ Structure de la base de données

| Table | Description |
|-------|-------------|
| `users` | Utilisateurs — champs : id, name, email, telephone, password, role, actif, avatar |
| `services` | Types de visa proposés |
| `documents_requis` | Pièces à fournir par service |
| `etapes` | Étapes de traitement par service |
| `infos_visa` | Informations visa et frais par service |
| `dossiers` | Dossiers clients — statuts : en_attente / en_cours / valide / refuse |
| `dossier_documents` | Fichiers uploadés + statut + commentaire admin |
| `dossier_etapes` | Suivi des étapes par dossier |
| `messages` | Messagerie client ↔ administrateur |
| `password_reset_tokens` | Tokens de réinitialisation de mot de passe |

---

## 🚀 Installation et lancement (en local)

### Prérequis
- PHP 8.3+
- Composer
- MySQL (XAMPP recommandé)
- Node.js (optionnel)

### Étapes

**1. Cloner le dépôt**
```bash
git clone https://github.com/Mfina-javerichalle/Eyon_consulting_web.git
cd Eyon_consulting_web
```

**2. Installer les dépendances**
```bash
composer install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

Modifier le fichier `.env` :
```properties
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_DATABASE=elyon_consulting_v2
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username_mailtrap
MAIL_PASSWORD=votre_password_mailtrap
MAIL_FROM_ADDRESS="contact@elyon-consulting.com"
MAIL_FROM_NAME="Elyon Consulting"
```

**4. Démarrer XAMPP (Apache + MySQL)**

**5. Créer la base de données**  
Dans phpMyAdmin, créer une base nommée `elyon_consulting_v2`

**6. Exécuter les migrations et les seeders**
```bash
php artisan migrate --seed
```

**7. Créer le lien de stockage**
```bash
php artisan storage:link
```

**8. Lancer le serveur**
```bash
php artisan serve
```

**9. Accéder à l'application**  
`http://localhost:8000`

---

## 🔐 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@elyon.test | password |
| Client | client@elyon.test | password |

---

## 🌐 Déploiement en production

Le site est déployé sur **o2switch** et accessible à :  
🔗 **[https://elyon-consulting.com](https://elyon-consulting.com)**

### Variables .env spécifiques à la production
```properties
APP_ENV=production
APP_DEBUG=false
APP_URL=https://elyon-consulting.com
FILESYSTEM_DISK=public
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### Commandes à exécuter sur le serveur (SSH)
```bash
cd /home/mfja3413/elyon
php artisan storage:link
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan migrate
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

> ⚠️ En production, les emails sont envoyés via **Gmail SMTP** avec un mot de passe d'application Google (`myaccount.google.com/apppasswords`).

---

## 📁 Structure du projet

```
elyon-consulting/
├── app/
│   ├── Http/
│   │   ├── Controllers/Web/
│   │   │   ├── AuthController.php        # Inscription, connexion, reset mdp
│   │   │   ├── ContactController.php     # Formulaire contact + email SMTP
│   │   │   ├── ClientController.php      # Dashboard + création dossier
│   │   │   ├── Admin/                    # CRUD services, docs, étapes, users
│   │   │   └── Client/                   # Profil + DossierController
│   │   ├── Controllers/Api/              # Controllers API REST (mobile)
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php       # Vérifie rôle admin + compte actif
│   │       └── ClientMiddleware.php      # Vérifie rôle client + compte actif
│   └── Models/                           # Modèles Eloquent
├── bootstrap/
│   └── app.php                           # Enregistrement middlewares (Laravel 11+)
├── database/
│   ├── migrations/                       # Structure BDD versionnée
│   └── seeders/                          # Données de test
├── resources/views/                      # Vues Blade
├── routes/
│   ├── web.php                           # Routes publiques + client + admin
│   └── api.php                           # Routes API REST
└── public/                               # Fichiers accessibles publiquement
```

---

## 🔒 Sécurité

| Mesure | Implémentation |
|--------|----------------|
| Hachage mots de passe | `Hash::make()` — Bcrypt — irréversible |
| Protection CSRF | `@csrf` sur tous les formulaires POST/DELETE |
| Isolation des données | Vérification `user_id === auth()->id()` dans chaque méthode |
| Contrôle d'accès | `AdminMiddleware` + `ClientMiddleware` sur toutes les routes protégées |
| Validation des fichiers | `mimes:pdf,jpg,jpeg,png,webp\|max:5120` (5 Mo) |
| Protection XSS | `e()` sur toutes les données utilisateur dans les emails |
| Injection SQL | Requêtes Eloquent paramétrées — jamais de SQL brut |
| HTTPS | SSL actif sur o2switch — certificat Let's Encrypt |
| Compte désactivé | Middleware vérifie `$user->actif` → déconnexion forcée |

---

## 📱 Application Mobile

L'application mobile Android (React Native / Expo) consomme l'API REST de ce projet.  
📱 Dépôt mobile : [Elyon_consulting_mobile](https://github.com/Mfina-javerichalle/Eyon_consulting_web)

---

## 📄 Documentation

📂 [Accéder à la documentation sur Google Drive](https://drive.google.com/drive/folders/1mnPxuYiy0xx9JAFyeN8Uq5jQe4GHWYnS?usp=sharing)

Contenu :
- Cahier des charges
- Diagrammes UML (cas d'utilisation, classes, séquence)
- Collection Postman
- Manuel utilisateur

---

## 👩‍💻 Auteure

**MFINA Javerichalle Maconslavie**  
BTS SIO — Option SLAM  
CFA SCHOLIA, Thiais  
Session 2026 — N° candidat : 02545873286

---

## 📋 Compétences BTS SIO couvertes

- Concevoir et développer une solution applicative
- Assurer la maintenance corrective ou évolutive d'une solution applicative
- Gérer les données
- Travailler en mode projet
