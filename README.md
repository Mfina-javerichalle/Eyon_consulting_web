# ELYON Consulting — Application Web

> Plateforme de gestion des démarches de mobilité internationale  
> BTS SIO — Option SLAM — Session 2026

---

## 📌 Présentation du projet

**ELYON Consulting** est une application web full-stack développée dans le cadre du BTS SIO SLAM.  
Elle simule une plateforme numérique permettant à une entreprise spécialisée dans la mobilité internationale de gérer les dossiers de demande de visa de ses clients (visa étudiant, touristique, de travail).

L'application remplace une gestion manuelle (e-mails, WhatsApp, papier) par un système centralisé, sécurisé et accessible depuis tout navigateur web.

---

## 🎯 Fonctionnalités principales

### Espace Client
- Inscription et connexion sécurisée (session Laravel)
- Consultation des services disponibles (visa étudiant, touristique, travail)
- Création et suivi de dossier avec étapes et statuts en temps réel
- Upload de pièces justificatives (PDF, JPEG, PNG — max 5 Mo)
- Consultation du statut des documents (en attente / validé / refusé)
- Re-soumission d'un document refusé
- Messagerie intégrée avec l'administrateur
- Gestion du profil (nom, email, avatar, mot de passe)
- Réinitialisation du mot de passe par email
- Formulaire de contact

### Espace Administrateur
- Tableau de bord avec statistiques (dossiers, utilisateurs, services)
- CRUD des services (ajout, modification, suppression)
- Gestion des documents requis par service
- Gestion des étapes par service
- Gestion des informations visa et des frais
- Validation / refus des documents soumis par les clients
- Mise à jour des statuts des dossiers et des étapes
- Gestion des utilisateurs (liste, profil, désactivation de compte)
- Messagerie : répondre aux clients par dossier

### API REST (pour l'application mobile)
- Authentification sécurisée via Laravel Sanctum (Bearer Token)
- Endpoints JSON pour tous les modules (services, dossiers, documents, étapes, messages)
- Documentation et tests via Postman

---

## 🛠️ Stack technique

| Couche | Technologie |
|--------|-------------|
| Backend | PHP 8.2, Laravel 12 (MVC, Eloquent ORM) |
| Frontend | Laravel Blade, Bootstrap 5, JavaScript ES6+ |
| Base de données | MySQL 8 (XAMPP / phpMyAdmin) |
| Authentification Web | Sessions Laravel |
| Authentification API | Laravel Sanctum (Bearer Token) |
| Migrations & Seeders | Eloquent (php artisan migrate) |
| Outils | GitHub, Postman, StarUML, VS Code, XAMPP |

---

## 🗄️ Structure de la base de données

| Table | Description |
|-------|-------------|
| `users` | Utilisateurs (clients et administrateurs) |
| `services` | Types de visa proposés |
| `documents_requis` | Pièces à fournir par service |
| `etapes` | Étapes de traitement par service |
| `infos_visa` | Informations visa et frais par service |
| `dossiers` | Dossiers créés par les clients |
| `dossier_documents` | Documents uploadés par dossier |
| `dossier_etapes` | Suivi des étapes par dossier |
| `messages` | Messagerie client ↔ administrateur |

---

## 🚀 Installation et lancement

### Prérequis
- PHP 8.2+
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
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elyon_consulting_v2
DB_USERNAME=root
DB_PASSWORD=
```

**4. Démarrer XAMPP** (Apache + MySQL)

**5. Créer la base de données**  
Dans phpMyAdmin, créer une base de données nommée `elyon_consulting_v2`

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
```
http://localhost:8000
```

---

## 🔐 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@elyon.test | password |
| Client | client@elyon.test | password |

---

## 📁 Structure du projet

```
elyon-consulting/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Web/        # Controllers pour les vues Blade
│   │   │   └── Api/        # Controllers pour l'API REST (mobile)
│   │   └── Middleware/     # AdminMiddleware, ClientMiddleware
│   ├── Models/             # Modèles Eloquent
│   └── Services/           # Logique métier partagée
├── database/
│   ├── migrations/         # Structure de la base de données
│   └── seeders/            # Données de test
├── resources/
│   └── views/              # Vues Blade (HTML côté serveur)
├── routes/
│   ├── web.php             # Routes de l'application web
│   └── api.php             # Routes de l'API REST
└── public/                 # Fichiers accessibles publiquement
```

---

## 📱 Application Mobile

L'application mobile Android (React Native / Expo) consomme l'API REST de ce projet.  
Dépôt mobile : [Elyon_consulting_mobile](https://github.com/Mfina-javerichalle/Elyon_consulting_mobile.git)

---

## 📄 Documentation

Tous les documents sont disponibles sur Google Drive :  
📂 [Accéder à la documentation](https://drive.google.com/drive/folders/1mnPxuYiy0xx9JAFyeN8Uq5jQe4GHWYnS?usp=sharing)

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
Session 2026  
N° candidat : 02545873286

---

## 📋 Compétences BTS SIO couvertes

- Concevoir et développer une solution applicative
- Assurer la maintenance corrective ou évolutive d'une solution applicative
- Gérer les données
