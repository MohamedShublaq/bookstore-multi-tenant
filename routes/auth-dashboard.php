<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('dashboard')->as('auth.')->group(function () {
    Route::prefix('login')->middleware('guest')->group(function () {
        Route::get('', 'showLogin')->name('showLogin');
        Route::post('', 'login')->name('login');
    });
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:admin,library-admin');
});
