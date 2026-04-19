<?php

use App\Http\Controllers\v1\User\LoginController;
use App\Http\Controllers\v1\User\LogoutController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

Route::get('/', function () {
    return Inertia::render('Welcome');
});
