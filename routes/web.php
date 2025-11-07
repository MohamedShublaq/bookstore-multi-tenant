<?php

use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact');
