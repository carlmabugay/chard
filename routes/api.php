<?php

use App\Http\Controllers\v1\CashFlow\ListController as ListCashFlowController;
use App\Http\Controllers\v1\CashFlow\RestoreController as RestoreCashFlowController;
use App\Http\Controllers\v1\CashFlow\ShowController as ShowCashFlowController;
use App\Http\Controllers\v1\CashFlow\StoreController as StoreCashFlowController;
use App\Http\Controllers\v1\CashFlow\TrashController as TrashCashFlowController;
use App\Http\Controllers\v1\CashFlow\UpdateController as UpdateCashFlowController;
use App\Http\Controllers\v1\Dividend\ListController as ListDividendController;
use App\Http\Controllers\v1\Dividend\ShowController as ShowDividendController;
use App\Http\Controllers\v1\Dividend\StoreController as StoreDividendController;
use App\Http\Controllers\v1\Dividend\TrashController as TrashDividendController;
use App\Http\Controllers\v1\Dividend\UpdateController as UpdateDividendController;
use App\Http\Controllers\v1\Portfolio\ListController as ListPortfolioController;
use App\Http\Controllers\v1\Portfolio\RestoreController as RestorePortfolioController;
use App\Http\Controllers\v1\Portfolio\ShowController as ShowPortfolioController;
use App\Http\Controllers\v1\Portfolio\StoreController as StorePortfolioController;
use App\Http\Controllers\v1\Portfolio\TrashController as TrashPortfolioController;
use App\Http\Controllers\v1\Portfolio\UpdateController as UpdatePortfolioController;
use App\Http\Controllers\v1\Strategy\ListController as ListStrategyController;
use App\Http\Controllers\v1\Strategy\RestoreController as RestoreStrategyController;
use App\Http\Controllers\v1\Strategy\ShowController as ShowStrategyController;
use App\Http\Controllers\v1\Strategy\StoreController as StoreStrategyController;
use App\Http\Controllers\v1\Strategy\TrashController as TrashStrategyController;
use App\Http\Controllers\v1\Strategy\UpdateController as UpdateStrategyController;
use App\Http\Controllers\v1\TradeLog\ListController as ListTradeLogController;
use App\Http\Controllers\v1\TradeLog\ShowController as ShowTradeLogController;
use App\Http\Controllers\v1\TradeLog\StoreController as StoreTradeLogController;
use App\Http\Controllers\v1\TradeLog\TrashController as TrashTradeLogController;
use App\Http\Controllers\v1\TradeLog\UpdateController as UpdateTradeLogController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::prefix('portfolios')->group(function () {
        Route::get('/', ListPortfolioController::class);
        Route::post('/', StorePortfolioController::class);
        Route::get('/{id}', ShowPortfolioController::class);
        Route::put('/', UpdatePortfolioController::class);
        Route::delete('/{id}', TrashPortfolioController::class);
        Route::patch('/{id}', RestorePortfolioController::class);
    });

    Route::prefix('strategies')->group(function () {
        Route::get('/', ListStrategyController::class);
        Route::post('/', StoreStrategyController::class);
        Route::get('/{id}', ShowStrategyController::class);
        Route::put('/', UpdateStrategyController::class);
        Route::delete('/{id}', TrashStrategyController::class);
        Route::patch('/{id}', RestoreStrategyController::class);
    });

    Route::prefix('cash-flows')->group(function () {
        Route::get('/', ListCashFlowController::class);
        Route::post('/', StoreCashFlowController::class);
        Route::get('/{id}', ShowCashFlowController::class);
        Route::put('/', UpdateCashFlowController::class);
        Route::delete('/{id}', TrashCashFlowController::class);
        Route::patch('/{id}', RestoreCashFlowController::class);
    });

    Route::prefix('dividends')->group(function () {
        Route::get('/', ListDividendController::class);
        Route::get('/{id}', ShowDividendController::class);
        Route::post('/', StoreDividendController::class);
        Route::put('/', UpdateDividendController::class);
        Route::delete('/{id}', TrashDividendController::class);
    });

    Route::prefix('trade-logs')->group(function () {
        Route::get('/', ListTradeLogController::class);
        Route::get('/{id}', ShowTradeLogController::class);
        Route::post('/', StoreTradeLogController::class);
        Route::put('/', UpdateTradeLogController::class);
        Route::delete('/{id}', TrashTradeLogController::class);
    });

});
