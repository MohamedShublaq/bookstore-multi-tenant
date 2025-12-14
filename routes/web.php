<?php

use App\Http\Controllers\Auth\Website\AuthController;
use App\Http\Controllers\MainSaasController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\RegisterController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.main_domain'))
    ->as('saas.')
    ->group(function () {
        Route::get('/', [MainSaasController::class, 'index']);
    });

Route::domain('{library}.' . config('app.main_domain'))
    ->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::prefix('login')->middleware('guest')->group(function () {
                Route::get('', 'showLogin')->name('showLogin');
                Route::post('', 'login')->name('login');
            });
            Route::post('/logout', 'logout')->name('logout')->middleware('auth:web');
        });

        Route::as('website.')
            ->group(function () {
                Route::get('/', [HomeController::class, 'home'])->name('home');
                Route::post('/contact', [ContactController::class, 'store'])->name('contact');
                Route::controller(RegisterController::class)->prefix('register')->group(function () {
                    Route::get('', 'showRegister')->name('showRegister');
                    Route::post('', 'register')->name('register');
                });
            });
    });
