<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /*
         * Enregistrement des middlewares personnalisés
         * "admin" → vérifie que l'utilisateur est admin
         * "client" → vérifie que l'utilisateur est client
         * On pourra les utiliser dans les routes comme ceci :
         * Route::middleware('admin')->group(...)
         * Route::middleware('client')->group(...)
         */
        $middleware->alias([
            'admin'  => \App\Http\Middleware\AdminMiddleware::class,
            'client' => \App\Http\Middleware\ClientMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();