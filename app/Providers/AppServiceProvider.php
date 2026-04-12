<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Middleware\RedirectIfAuthenticated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * On définit ici que la route de connexion est 'home'
     * car on utilise des modals au lieu d'une page login séparée
     */
    public function boot(): void
    {
        // Dire à Laravel que la route de connexion c'est la home
        // (car on utilise des modals Bootstrap au lieu d'une page dédiée)
        \Illuminate\Support\Facades\Route::bind('login', function() {
            return redirect()->route('home');
        });
    }
}