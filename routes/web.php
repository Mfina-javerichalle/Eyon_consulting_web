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
| Accessibles sans connexion
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login',    [AuthController::class, 'login'])->name('login');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── Mot de passe oublié (envoi du lien par email)
Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// ── Réinitialisation du mot de passe (depuis le lien reçu par email)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password',        [AuthController::class, 'resetPassword'])->name('password.update');

// ── Changement de mot de passe depuis le profil (utilisateur connecté)
Route::middleware('auth')->post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

// ── Services publics (visibles sans connexion)
Route::get('/services',           [WebServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [WebServiceController::class, 'show'])->name('services.show');

// ── Page contact
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Routes Admin
| Protégées par le middleware 'admin' (vérifie role = 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // ── Tableau de bord
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ── Page dédiée d'un dossier
    // Affiche les 4 onglets : Statut | Documents | Étapes | Messages
    Route::get('/dossiers/{dossier}', [AdminController::class, 'showDossier'])->name('dossiers.show');

    // ── Modifier le statut global d'un dossier (en_attente, en_cours, valide, refuse)
    Route::post('/dossiers/{dossier}/statut', [AdminController::class, 'changerStatutDossier'])
        ->name('dossiers.statut');

    // ── Mettre à jour le statut d'une étape spécifique d'un dossier
    // Ex: POST /admin/dossiers/3/etapes/7  avec body: statut=en_cours
    Route::post('/dossiers/{dossier}/etapes/{dossierEtape}', [AdminController::class, 'updateEtape'])
        ->name('dossiers.etapes.update');

    // ── Messagerie admin → client
    Route::post('/dossiers/{dossier}/messages', [AdminController::class, 'sendMessage'])
        ->name('dossiers.messages.store');

    // ── Effacer toute la conversation d'un dossier
    Route::delete('/dossiers/{dossier}/messages', [AdminController::class, 'clearMessages'])
        ->name('dossiers.messages.clear');

    // ── Documents uploadés par les clients : valider / refuser / supprimer
    Route::post('/documents/{document}/valider',     [AdminController::class, 'validerDocument'])
        ->name('documents.valider');
    Route::post('/documents/{document}/refuser',     [AdminController::class, 'refuserDocument'])
        ->name('documents.refuser');
    Route::delete('/documents/{document}/supprimer', [AdminController::class, 'supprimerDocument'])
        ->name('documents.supprimer');

    // ── Profil admin
    Route::post('/profile/avatar', [AdminProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/profile/update', [AdminProfileController::class, 'updateProfile'])->name('profile.update');

    // ── CRUD Services
    Route::post('/services',             [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}',    [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    // ── CRUD Documents requis (configuration par service)
    Route::post('/documents',              [DocumentRequisController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}',    [DocumentRequisController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentRequisController::class, 'destroy'])->name('documents.destroy');

    // ── CRUD Étapes (configuration par service)
    Route::post('/etapes',           [EtapeController::class, 'store'])->name('etapes.store');
    Route::put('/etapes/{etape}',    [EtapeController::class, 'update'])->name('etapes.update');
    Route::delete('/etapes/{etape}', [EtapeController::class, 'destroy'])->name('etapes.destroy');

    // ── CRUD Infos Visa
    Route::post('/infos-visa',               [InfosVisaController::class, 'store'])->name('infosVisa.store');
    Route::put('/infos-visa/{infosVisa}',    [InfosVisaController::class, 'update'])->name('infosVisa.update');
    Route::delete('/infos-visa/{infosVisa}', [InfosVisaController::class, 'destroy'])->name('infosVisa.destroy');

    // ── Gestion des utilisateurs
    Route::patch('/users/{user}/toggle-actif', [UserController::class, 'toggleActif'])->name('users.toggleActif');
    Route::delete('/users/{user}',             [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Client
| Protégées par le middleware 'client' (vérifie role = 'client')
|--------------------------------------------------------------------------
*/
Route::middleware('client')->prefix('client')->name('client.')->group(function () {

    // ── Tableau de bord client
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');

    // ── Profil client
    Route::post('/profile/avatar', [ClientProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/profile/update', [ClientProfileController::class, 'updateProfile'])->name('profile.update');

    // ── Créer un nouveau dossier
    Route::post('/dossiers', [ClientController::class, 'storeDossier'])->name('dossiers.store');

    // ── Page de détail d'un dossier
    // Affiche les 3 onglets : Documents | Étapes | Messages
    Route::get('/dossiers/{dossier}', [ClientDossierController::class, 'show'])->name('dossiers.show');

    // ── Upload d'un document par le client
    Route::post('/dossiers/{dossier}/documents', [ClientDossierController::class, 'uploadDocument'])
        ->name('dossiers.documents.upload');

    // ── Suppression d'un document par le client (sauf si déjà validé)
    Route::delete('/dossiers/{dossier}/documents/{document}', [ClientDossierController::class, 'deleteDocument'])
        ->name('dossiers.documents.delete');

    // ── Envoi d'un message au client → admin
    Route::post('/dossiers/{dossier}/messages', [ClientDossierController::class, 'sendMessage'])
        ->name('dossiers.messages.store');

    // ── Effacer l'historique des messages
    Route::delete('/dossiers/{dossier}/messages', [ClientDossierController::class, 'clearMessages'])
        ->name('dossiers.messages.clear');
});