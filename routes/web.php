<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\ServiceController as WebServiceController;
use App\Http\Controllers\Web\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Web\Admin\DocumentRequisController;
use App\Http\Controllers\Web\Admin\EtapeController;
use App\Http\Controllers\Web\Admin\InfosVisaController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Web\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Web\Client\DossierController as ClientDossierController;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login',    [AuthController::class, 'login'])->name('login');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// Mot de passe oublié
Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Réinitialisation du mot de passe
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password',        [AuthController::class, 'resetPassword'])->name('password.update');

// Changement de mot de passe depuis le profil (connecté)
Route::middleware('auth')->post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

// Services publics
Route::get('/services',           [WebServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [WebServiceController::class, 'show'])->name('services.show');

// Contact
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Page dédiée d'un dossier — statut + documents + messagerie
    Route::get('/dossiers/{dossier}', [AdminController::class, 'showDossier'])->name('dossiers.show');

    // Profil
    Route::post('/profile/avatar', [AdminProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/profile/update', [AdminProfileController::class, 'updateProfile'])->name('profile.update');

    // Services
    Route::post('/services',            [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}',   [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}',[AdminServiceController::class, 'destroy'])->name('services.destroy');

    // Documents requis (configuration)
    Route::post('/documents',              [DocumentRequisController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}',    [DocumentRequisController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentRequisController::class, 'destroy'])->name('documents.destroy');

    // Étapes
    Route::post('/etapes',          [EtapeController::class, 'store'])->name('etapes.store');
    Route::put('/etapes/{etape}',   [EtapeController::class, 'update'])->name('etapes.update');
    Route::delete('/etapes/{etape}',[EtapeController::class, 'destroy'])->name('etapes.destroy');

    // Infos Visa
    Route::post('/infos-visa',              [InfosVisaController::class, 'store'])->name('infosVisa.store');
    Route::put('/infos-visa/{infosVisa}',   [InfosVisaController::class, 'update'])->name('infosVisa.update');
    Route::delete('/infos-visa/{infosVisa}',[InfosVisaController::class, 'destroy'])->name('infosVisa.destroy');

    // Utilisateurs
    Route::patch('/users/{user}/toggle-actif', [UserController::class, 'toggleActif'])->name('users.toggleActif');
    Route::delete('/users/{user}',             [UserController::class, 'destroy'])->name('users.destroy');

    // Dossiers — statut + messages
    Route::post('/dossiers/{dossier}/statut',   [AdminController::class, 'changerStatutDossier'])->name('dossiers.statut');
    Route::post('/dossiers/{dossier}/messages', [AdminController::class, 'sendMessage'])->name('dossiers.messages.store');

    // Dossiers — effacer l'historique des messages
    Route::delete('/dossiers/{dossier}/messages', [AdminController::class, 'clearMessages'])->name('dossiers.messages.clear');

    // Documents uploadés par les clients — valider / refuser / supprimer
    Route::post('/documents/{document}/valider',    [AdminController::class, 'validerDocument'])->name('documents.valider');
    Route::post('/documents/{document}/refuser',    [AdminController::class, 'refuserDocument'])->name('documents.refuser');
    Route::delete('/documents/{document}/supprimer',[AdminController::class, 'supprimerDocument'])->name('documents.supprimer');
});

/*
|--------------------------------------------------------------------------
| Routes Client
|--------------------------------------------------------------------------
*/
Route::middleware('client')->prefix('client')->name('client.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::post('/profile/avatar', [ClientProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/profile/update', [ClientProfileController::class, 'updateProfile'])->name('profile.update');

    // Dossiers
    Route::post('/dossiers', [ClientController::class, 'storeDossier'])->name('dossiers.store');

    // Détail dossier
    Route::get('/dossiers/{dossier}', [ClientDossierController::class, 'show'])->name('dossiers.show');

    // Documents — upload
    Route::post('/dossiers/{dossier}/documents',
        [ClientDossierController::class, 'uploadDocument']
    )->name('dossiers.documents.upload');

    // Documents — suppression
    Route::delete('/dossiers/{dossier}/documents/{document}',
        [ClientDossierController::class, 'deleteDocument']
    )->name('dossiers.documents.delete');

    // Messages — envoi
    Route::post('/dossiers/{dossier}/messages',
        [ClientDossierController::class, 'sendMessage']
    )->name('dossiers.messages.store');

    // Messages — effacer l'historique
    Route::delete('/dossiers/{dossier}/messages',
        [ClientDossierController::class, 'clearMessages']
    )->name('dossiers.messages.clear');
});