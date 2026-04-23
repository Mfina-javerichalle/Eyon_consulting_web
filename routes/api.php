<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DossierController;
use App\Http\Controllers\Api\MessageController;

/*
|--------------------------------------------------------------------------
| Routes API — Publiques (sans token)
|--------------------------------------------------------------------------
*/
Route::post('/auth/register',        [AuthController::class, 'register']);
Route::post('/auth/login',           [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('/services',           [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Routes API — Protégées (Bearer Token requis)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout',     [AuthController::class, 'logout']);
    Route::get('/auth/profil',      [AuthController::class, 'profil']);
    Route::post('/auth/avatar',     [AuthController::class, 'updateAvatar']);
    Route::put('/auth/profile',     [AuthController::class, 'updateProfile']);
    Route::delete('/auth/account',  [AuthController::class, 'deleteAccount']);

    // Dossiers
    Route::get('/dossiers',                      [DossierController::class, 'index']);
    Route::post('/dossiers',                     [DossierController::class, 'store']);
    Route::get('/dossiers/{dossier}',            [DossierController::class, 'show']);
    Route::post('/dossiers/{dossier}/documents', [DossierController::class, 'uploadDocument']);

    // Messages
    Route::get('/dossiers/{dossier}/messages',  [MessageController::class, 'index']);
    Route::post('/dossiers/{dossier}/messages', [MessageController::class, 'store']);

});