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
*/

Route::post('/auth/register',        [AuthController::class, 'register']);
Route::post('/auth/login',           [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('/services',           [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Routes API — Protégées (Bearer Token Sanctum requis)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // ── Authentification ──────────────────────────────────
    Route::post('/auth/logout',          [AuthController::class, 'logout']);
    Route::get('/auth/profil',           [AuthController::class, 'profil']);
    Route::put('/auth/profile',          [AuthController::class, 'updateProfile']);
    Route::put('/auth/change-password',  [AuthController::class, 'changePassword']);
    Route::post('/auth/avatar',          [AuthController::class, 'updateAvatar']);
    Route::delete('/auth/account',       [AuthController::class, 'deleteAccount']);

    // ── Dossiers ──────────────────────────────────────────
    Route::get('/dossiers',  [DossierController::class, 'index']);
    Route::post('/dossiers', [DossierController::class, 'store']);

    // ✅ IMPORTANT : cette route DOIT être AVANT /dossiers/{dossier}
    // Sinon Laravel interprète "messages" comme un ID de dossier
    // et retourne une erreur 404 ou un mauvais résultat.
    // Retourne : { unread_count: 3 }
    Route::get('/dossiers/messages/unread-count', [MessageController::class, 'unreadCount']);

    // Détail d'un dossier (avec documents et étapes)
    Route::get('/dossiers/{dossier}',             [DossierController::class, 'show']);

    // Upload document
    Route::post('/dossiers/{dossier}/documents',  [DossierController::class, 'uploadDocument']);

    // ── Messages ──────────────────────────────────────────
    Route::get('/dossiers/{dossier}/messages',        [MessageController::class, 'index']);
    Route::post('/dossiers/{dossier}/messages',       [MessageController::class, 'store']);
    Route::post('/dossiers/{dossier}/messages/read',  [MessageController::class, 'markAsRead']);

});