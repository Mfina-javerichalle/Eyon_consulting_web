<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Routes API — Publiques (sans token)
| Accessibles par tout le monde — pas besoin d'être connecté
|--------------------------------------------------------------------------
*/

// Inscription
Route::post('/auth/register', [AuthController::class, 'register']);

// Connexion
Route::post('/auth/login', [AuthController::class, 'login']);

// Mot de passe oublié
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

/*
|--------------------------------------------------------------------------
| Routes API — Protégées (Bearer Token requis)
| Le mobile doit envoyer : Authorization: Bearer {token} dans le header
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Déconnexion
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Profil de l'utilisateur connecté
    Route::get('/auth/profil', [AuthController::class, 'profil']);

    // ── Les routes suivantes seront ajoutées dans les prochaines phases ──
    // GET  /api/services          → liste des services
    // GET  /api/dossiers          → mes dossiers
    // POST /api/dossiers          → créer un dossier
    // POST /api/dossiers/{id}/documents → uploader un document
    // GET  /api/messages          → messagerie
    // POST /api/messages          → envoyer un message

});