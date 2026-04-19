<?php

use App\Http\Controllers\v1\User\LoginController;
use App\Http\Controllers\v1\User\LogoutController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

Route::get('/', HomeController::class)->name('home');
