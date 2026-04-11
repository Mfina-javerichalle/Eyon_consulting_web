<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\Admin\ServiceController;
use App\Http\Controllers\Web\Admin\DocumentRequisController;
use App\Http\Controllers\Web\Admin\EtapeController;
use App\Http\Controllers\Web\Admin\InfosVisaController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Routes publiques — accessibles sans être connecté
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('home');
})->name('home');

// Inscription
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Connexion
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mot de passe oublié
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Réinitialisation du mot de passe
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Modification mot de passe depuis le profil
Route::middleware('auth')->post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

// Page services (temporaire)
Route::get('/services', function () {
    return view('home');
})->name('services.index');

// Page contact (temporaire)
Route::get('/contact', function () {
    return view('home');
})->name('contact');

/*
|--------------------------------------------------------------------------
| Routes Admin — protégées par le middleware "admin"
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Profil admin — avatar et infos
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    // CRUD Services
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // CRUD Documents requis
    Route::post('/documents', [DocumentRequisController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}', [DocumentRequisController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentRequisController::class, 'destroy'])->name('documents.destroy');

    // CRUD Étapes
    Route::post('/etapes', [EtapeController::class, 'store'])->name('etapes.store');
    Route::put('/etapes/{etape}', [EtapeController::class, 'update'])->name('etapes.update');
    Route::delete('/etapes/{etape}', [EtapeController::class, 'destroy'])->name('etapes.destroy');

    // CRUD Infos Visa
    Route::post('/infos-visa', [InfosVisaController::class, 'store'])->name('infosVisa.store');
    Route::put('/infos-visa/{infosVisa}', [InfosVisaController::class, 'update'])->name('infosVisa.update');
    Route::delete('/infos-visa/{infosVisa}', [InfosVisaController::class, 'destroy'])->name('infosVisa.destroy');

    // Gestion utilisateurs
    Route::patch('/users/{user}/toggle-actif', [UserController::class, 'toggleActif'])->name('users.toggleActif');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Client — protégées par le middleware "client"
|--------------------------------------------------------------------------
*/
Route::middleware('client')->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::middleware('client')->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');

    // Profil client
    Route::post('/profile/avatar', [\App\Http\Controllers\Web\Client\ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/profile/update', [\App\Http\Controllers\Web\Client\ProfileController::class, 'updateProfile'])->name('profile.update');
});
});