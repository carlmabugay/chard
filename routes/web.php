<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\LogoutController;
use App\Http\Controllers\Web\Pages\DashboardController;
use App\Http\Controllers\Web\Pages\HomeController;
use App\Http\Controllers\Web\Pages\LoginController as WebLoginController;
use App\Http\Controllers\Web\Pages\StrategyController;
use App\Http\Controllers\Web\StrategyController as StoreStrategyController;
use Illuminate\Support\Facades\Route;

// Route::post('/login', LoginController::class);
// Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

Route::get('/', HomeController::class)->name('home');
Route::get('/login', WebLoginController::class)->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/login', AuthController::class)->name('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/strategy', StrategyController::class)->name('strategy.index');
    Route::post('/strategy', StoreStrategyController::class)->name('strategy.store');
});
