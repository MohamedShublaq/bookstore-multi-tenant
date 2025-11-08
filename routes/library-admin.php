<?php

use App\Http\Controllers\Library\AdminController;
use App\Http\Controllers\Library\AuthorController;
use App\Http\Controllers\Library\BookController;
use App\Http\Controllers\Library\CategoryController;
use App\Http\Controllers\Library\ChangePasswordController;
use App\Http\Controllers\Library\ContactController;
use App\Http\Controllers\Library\CouponController;
use App\Http\Controllers\Library\HomeController;
use App\Http\Controllers\Library\LanguageController;
use App\Http\Controllers\Library\PublisherController;
use App\Http\Controllers\Library\ShippingAreaController;
use App\Http\Controllers\Library\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:library-admin')->prefix('library')->as('library.')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::controller(ChangePasswordController::class)->prefix('change-password')->group(function () {
        Route::get('', 'index')->name('showChangePassword');
        Route::patch('', 'changePassword')->name('changePassword');
    });
    Route::middleware('library.manager')->group(function () {
        Route::resource('admins', AdminController::class)->except('show');
        Route::controller(AdminController::class)->prefix('admins')->as('admins.')->group(function () {
            Route::get('data', 'getAdmins')->name('data');
            Route::patch('{admin}/reset-password', 'resetPassword')->name('resetPassword');
        });
    });
    Route::resource('languages', LanguageController::class)->except('show');
    Route::get('/languages/data', [LanguageController::class, 'getLanguages'])->name('languages.data');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::get('/categories/data', [CategoryController::class, 'getCategories'])->name('categories.data');
    Route::resource('shipping-areas', ShippingAreaController::class)->except('show');
    Route::get('/shipping-areas/data', [ShippingAreaController::class, 'getShippingAreas'])->name('shipping-areas.data');
    Route::resource('authors', AuthorController::class)->except('show');
    Route::get('/authors/data', [AuthorController::class, 'getAuthors'])->name('authors.data');
    Route::resource('publishers', PublisherController::class)->except('show');
    Route::get('/publishers/data', [PublisherController::class, 'getPublishers'])->name('publishers.data');
    Route::controller(UserController::class)->prefix('users')->as('users.')->group(function () {
        Route::get('data', 'getUsers')->name('data');
        Route::get('addresses', 'getAddresses')->name('addresses');
    });
    Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
    Route::resource('contacts', ContactController::class)->only(['index', 'destroy']);
    Route::get('/contacts/data', [ContactController::class, 'getContacts'])->name('contacts.data');
    Route::controller(BookController::class)->prefix('books')->as('books.')->group(function () {
        Route::get('data', 'getBooks')->name('data');
        Route::patch('{id}/change-status', 'changeStatus')->name('changeStatus');
    });
    Route::resource('books', BookController::class);
    Route::controller(CouponController::class)->prefix('coupons')->as('coupons.')->group(function () {
        Route::get('data', 'getCoupons')->name('data');
        Route::get('generate-code', 'generateCode')->name('generateCode');
        Route::patch('{id}/change-status', 'changeStatus')->name('changeStatus');
    });
    Route::resource('coupons', CouponController::class);
});
