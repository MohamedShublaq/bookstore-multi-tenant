<?php

use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LibraryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::resource('libraries', LibraryController::class)->except('show');
    Route::controller(LibraryController::class)->prefix('libraries')->as('libraries.')->group(function () {
        Route::get('data', 'getLibraries')->name('data');
        Route::get('{id}/admins', 'showAllAdmins')->name('showAllAdmins');
        Route::get('admins/data', 'getAllAdmins')->name('getAllAdmins');
        Route::patch('{id}/change-status', 'changeStatus')->name('changeStatus');
        Route::patch('admin/{id}/reset-password', 'resetAdminPassword')->name('resetAdminPassword');
    });
    Route::controller(ChangePasswordController::class)->prefix('change-password')->group(function () {
        Route::get('', 'index')->name('showChangePassword');
        Route::patch('', 'changePassword')->name('changePassword');
    });
});
