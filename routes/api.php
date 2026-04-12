<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DossierController;
use App\Http\Controllers\Api\MessageController;

/*
|--------------------------------------------------------------------------
| Routes API — Publiques (sans token)
| Accessibles par tout le monde — pas besoin d'être connecté
|--------------------------------------------------------------------------
*/

// Authentification
Route::post('/auth/register',        [AuthController::class, 'register']);
Route::post('/auth/login',           [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

// Services — publics (le mobile affiche la liste sans connexion)
Route::get('/services',          [ServiceController::class, 'index']);
Route::get('/services/{service}',[ServiceController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Routes API — Protégées (Bearer Token requis)
| Le mobile doit envoyer : Authorization: Bearer {token} dans le header
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profil',  [AuthController::class, 'profil']);

    // Dossiers
    Route::get('/dossiers',                          [DossierController::class, 'index']);
    Route::post('/dossiers',                         [DossierController::class, 'store']);
    Route::get('/dossiers/{dossier}',                [DossierController::class, 'show']);
    Route::post('/dossiers/{dossier}/documents',     [DossierController::class, 'uploadDocument']);

    // Messages
    Route::get('/dossiers/{dossier}/messages',  [MessageController::class, 'index']);
    Route::post('/dossiers/{dossier}/messages', [MessageController::class, 'store']);
});