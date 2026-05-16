<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DossierController;
use App\Http\Controllers\Api\MessageController;

/*
|--------------------------------------------------------------------------
| Routes API — Publiques (sans token Bearer)
|--------------------------------------------------------------------------
|
| Ces routes sont accessibles sans authentification.
| Utilisées pour la connexion, l'inscription et la
| consultation publique des services.
|
*/

// ── Authentification publique ─────────────────────────────────
Route::post('/auth/register',        [AuthController::class, 'register']);
Route::post('/auth/login',           [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

// ── Services — consultation publique (sans compte) ───────────
Route::get('/services',           [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Routes API — Protégées (Bearer Token Sanctum requis)
|--------------------------------------------------------------------------
|
| Toutes ces routes nécessitent un token valide dans le header :
|   Authorization: Bearer {token}
|
| Le token est généré lors du login et stocké dans AsyncStorage
| côté application mobile.
|
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |----------------------------------------------------------------------
    | AUTHENTIFICATION — Gestion du compte
    |----------------------------------------------------------------------
    */

    // Déconnexion — révoque le token Sanctum actuel
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Récupérer le profil de l'utilisateur connecté
    // Retourne : { id, name, email, telephone, role, avatar }
    Route::get('/auth/profil', [AuthController::class, 'profil']);

    // Mettre à jour le profil (nom, email, téléphone)
    // Body : { name, email, telephone }
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);

    // Changer le mot de passe
    // Body : { current_password, password, password_confirmation }
    Route::put('/auth/change-password', [AuthController::class, 'changePassword']);

    // Mettre à jour l'avatar (multipart/form-data)
    // Body : form-data avec champ "avatar" (image)
    Route::post('/auth/avatar', [AuthController::class, 'updateAvatar']);

    // Supprimer le compte définitivement
    // Body : { password } — confirmation obligatoire
    Route::delete('/auth/account', [AuthController::class, 'deleteAccount']);


    /*
    |----------------------------------------------------------------------
    | DOSSIERS — Gestion des dossiers client
    |----------------------------------------------------------------------
    */

    // Lister tous les dossiers du client connecté
    // Retourne : { dossiers: [...], total: n }
    Route::get('/dossiers', [DossierController::class, 'index']);

    // Créer un nouveau dossier
    // Body : { service_id }
    Route::post('/dossiers', [DossierController::class, 'store']);

    // Détail d'un dossier (avec documents et étapes)
    // Retourne : { dossier: { id, statut, service, documents, etapes } }
    Route::get('/dossiers/{dossier}', [DossierController::class, 'show']);

    // Uploader un document pour un dossier
    // Body : multipart/form-data
    //   - document_requis_id (integer) : ID du document requis
    //   - fichier             (file)    : PDF, JPG, PNG — max 5Mo
    // Le fichier est stocké dans storage/app/public/documents/
    // et visible immédiatement dans le back-office web via
    // /storage/documents/{filename}
    Route::post('/dossiers/{dossier}/documents', [DossierController::class, 'uploadDocument']);


    /*
    |----------------------------------------------------------------------
    | MESSAGES — Messagerie par dossier
    |----------------------------------------------------------------------
    |
    | Chaque dossier possède sa propre conversation entre
    | le client et l'administrateur/conseiller.
    |
    */

    // Lister les messages d'un dossier (historique complet)
    // Retourne : { messages: [{ id, contenu, is_mine, created_at, sender }] }
    // Les dates sont en UTC — le mobile les convertit en heure locale
    Route::get('/dossiers/{dossier}/messages', [MessageController::class, 'index']);

    // Envoyer un nouveau message dans un dossier
    // Body : { contenu }
    Route::post('/dossiers/{dossier}/messages', [MessageController::class, 'store']);

    // ── NOUVEAU : Marquer tous les messages d'un dossier comme lus ────
    //
    // Appelé automatiquement par le mobile à l'ouverture d'une
    // conversation. Met à jour is_read = true pour tous les messages
    // reçus (sender_id != auth()->id()) dans ce dossier.
    //
    // Retourne : { success: true }
    Route::post('/dossiers/{dossier}/messages/read', [MessageController::class, 'markAsRead']);

    // ── NOUVEAU : Nombre total de messages non lus (tous dossiers) ────
    //
    // Utilisé par l'application mobile pour afficher le badge rouge
    // sur l'onglet "Messages" dans la barre de navigation inférieure.
    // Polling toutes les 30 secondes depuis AppNavigator.
    //
    // IMPORTANT : Cette route DOIT être déclarée AVANT la route
    // /dossiers/{dossier}/messages pour éviter que Laravel
    // interprète "unread-count" comme un {dossier}.
    //
    // Retourne : { unread_count: 3 }
    Route::get('/dossiers/messages/unread-count', [MessageController::class, 'unreadCount']);

});