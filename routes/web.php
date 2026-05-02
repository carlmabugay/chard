<?php

use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\LogoutController;
use App\Http\Controllers\Site\Pages\CashFlow\IndexController as ListCashFlowController;
use App\Http\Controllers\Site\Pages\CashFlow\ShowController as ShowCashFlowController;
use App\Http\Controllers\Site\Pages\CashFlow\StoreController as StoreCashFlowController;
use App\Http\Controllers\Site\Pages\CashFlow\TrashController as TrashCashFlowController;
use App\Http\Controllers\Site\Pages\CashFlow\UpdateController as UpdateCashFlowController;
use App\Http\Controllers\Site\Pages\DashboardController;
use App\Http\Controllers\Site\Pages\Dividend\IndexController as ListDividendsController;
use App\Http\Controllers\Site\Pages\Dividend\ShowController as ShowDividendController;
use App\Http\Controllers\Site\Pages\Dividend\StoreController as StoreDividendController;
use App\Http\Controllers\Site\Pages\Dividend\TrashController as TrashDividendController;
use App\Http\Controllers\Site\Pages\Dividend\UpdateController as UpdateDividendController;
use App\Http\Controllers\Site\Pages\HomeController;
use App\Http\Controllers\Site\Pages\LoginController as WebLoginController;
use App\Http\Controllers\Site\Pages\Portfolio\IndexController as ListPortfolioController;
use App\Http\Controllers\Site\Pages\Portfolio\StoreController as StorePortfolioController;
use App\Http\Controllers\Site\Pages\Portfolio\TrashController as TrashPortfolioController;
use App\Http\Controllers\Site\Pages\Portfolio\UpdateController as UpdatePortfolioController;
use App\Http\Controllers\Site\Pages\Strategy\IndexController as ListStrategyController;
use App\Http\Controllers\Site\Pages\Strategy\ShowController as ShowStrategyController;
use App\Http\Controllers\Site\Pages\Strategy\StoreController as StoreStrategyController;
use App\Http\Controllers\Site\Pages\Strategy\TrashController as TrashStrategyController;
use App\Http\Controllers\Site\Pages\Strategy\UpdateController as UpdateStrategyController;
use App\Http\Controllers\Site\Pages\TradeLog\IndexController as ListTradeLogsController;
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

    Route::prefix('strategy')->group(function () {
        Route::get('/', ListStrategyController::class)->name('strategy.index');
        Route::get('/{strategy}', ShowStrategyController::class)->name('strategy.show');
        Route::post('/', StoreStrategyController::class)->name('strategy.store');
        Route::put('/{strategy}', UpdateStrategyController::class)->name('strategy.update');
        Route::delete('/{strategy}/trash', TrashStrategyController::class)->name('strategy.trash');
    });

    Route::prefix('portfolio')->group(function () {
        Route::get('/', ListPortfolioController::class)->name('portfolio.index');
        Route::post('/', StorePortfolioController::class)->name('portfolio.store');
        Route::put('/{portfolio}', UpdatePortfolioController::class)->name('portfolio.update');
        Route::delete('/{portfolio}/trash', TrashPortfolioController::class)->name('portfolio.trash');

    });

    Route::prefix('portfolio')->group(function () {
        Route::get('/cash_flow', ListCashFlowController::class)->name('cash_flow.index');
        Route::get('/{cash_flow}', ShowCashFlowController::class)->name('cash_flow.show');
        Route::post('/', StoreCashFlowController::class)->name('cash_flow.store');
        Route::put('/{cash_flow}', UpdateCashFlowController::class)->name('cash_flow.update');
        Route::delete('/{cash_flow}/trash', TrashCashFlowController::class)->name('cash_flow.trash');
    });

    Route::prefix('dividend')->group(function () {
        Route::get('/', ListDividendsController::class)->name('dividend.index');
        Route::get('/{dividend}', ShowDividendController::class)->name('dividend.show');
        Route::post('/', StoreDividendController::class)->name('dividend.store');
        Route::put('/{dividend}', UpdateDividendController::class)->name('dividend.update');
        Route::delete('/{dividend}/trash', TrashDividendController::class)->name('dividend.trash');
    });

    Route::prefix('trade_log')->group(function () {
        Route::get('/', ListTradeLogsController::class)->name('trade_log.index');
    });

});
