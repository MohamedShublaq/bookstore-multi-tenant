<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/super-admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/library-admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/auth-dashboard.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function () {
            if (request()->is("dashboard/*") || request()->is("library/*")) {
                return route('auth.showLogin');
            }
            return route('login');
        });

        $middleware->redirectUsersTo(function () {
            if (Auth::guard('admin')->check()) {
                return route('dashboard.home');
            }
            if (Auth::guard('library-admin')->check()) {
                return route('library.home');
            }
            return route('website.home');
        });

        // Route Middleware
        $middleware->alias([
            'library.manager'  => \App\Http\Middleware\LibraryManager::class,
        ]);

        //Global middlewares
        $middleware->use([
            \App\Http\Middleware\IdentifyTenant::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
