<?php

use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\LogoutController;
use App\Http\Controllers\Site\Pages\CashFlowController;
use App\Http\Controllers\Site\Pages\DashboardController;
use App\Http\Controllers\Site\Pages\DividendController;
use App\Http\Controllers\Site\Pages\HomeController;
use App\Http\Controllers\Site\Pages\LoginController as WebLoginController;
use App\Http\Controllers\Site\Pages\PortfolioController;
use App\Http\Controllers\Site\Pages\Strategy\IndexController;
use App\Http\Controllers\Site\Pages\Strategy\StoreController as StoreStrategyController;
use App\Http\Controllers\Site\Pages\TradeLogController;
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

    Route::get('/strategy', IndexController::class)->name('strategy.index');
    Route::post('/strategy', StoreStrategyController::class)->name('strategy.store');

    Route::get('/portfolio', PortfolioController::class)->name('portfolio.index');

    Route::get('/cash-flow', CashFlowController::class)->name('cash-flow.index');

    Route::get('/dividend', DividendController::class)->name('dividend.index');

    Route::get('/trade-log', TradeLogController::class)->name('trade-log.index');
});
