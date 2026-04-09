<?php

use App\Http\Controllers\v1\CashFlow\DestroyController as DestroyCashFlowController;
use App\Http\Controllers\v1\CashFlow\ListController as ListCashFlowController;
use App\Http\Controllers\v1\CashFlow\RestoreController as RestoreCashFlowController;
use App\Http\Controllers\v1\CashFlow\ShowController as ShowCashFlowController;
use App\Http\Controllers\v1\CashFlow\StoreController as StoreCashFlowController;
use App\Http\Controllers\v1\CashFlow\TrashController as TrashCashFlowController;
use App\Http\Controllers\v1\CashFlow\UpdateController as UpdateCashFlowController;
use App\Http\Controllers\v1\Dividend\DestroyController as DestroyDividendController;
use App\Http\Controllers\v1\Dividend\ListController as ListDividendController;
use App\Http\Controllers\v1\Dividend\RestoreController as RestoreDividendController;
use App\Http\Controllers\v1\Dividend\ShowController as ShowDividendController;
use App\Http\Controllers\v1\Dividend\StoreController as StoreDividendController;
use App\Http\Controllers\v1\Dividend\TrashController as TrashDividendController;
use App\Http\Controllers\v1\Dividend\UpdateController as UpdateDividendController;
use App\Http\Controllers\v1\Portfolio\DestroyController as DestroyPortfolioController;
use App\Http\Controllers\v1\Portfolio\ListController as ListPortfolioController;
use App\Http\Controllers\v1\Portfolio\RestoreController as RestorePortfolioController;
use App\Http\Controllers\v1\Portfolio\ShowController as ShowPortfolioController;
use App\Http\Controllers\v1\Portfolio\StoreController as StorePortfolioController;
use App\Http\Controllers\v1\Portfolio\TrashController as TrashPortfolioController;
use App\Http\Controllers\v1\Portfolio\UpdateController as UpdatePortfolioController;
use App\Http\Controllers\v1\Strategy\DestroyController as DestroyStrategyController;
use App\Http\Controllers\v1\Strategy\ListController as ListStrategyController;
use App\Http\Controllers\v1\Strategy\RestoreController as RestoreStrategyController;
use App\Http\Controllers\v1\Strategy\ShowController as ShowStrategyController;
use App\Http\Controllers\v1\Strategy\StoreController as StoreStrategyController;
use App\Http\Controllers\v1\Strategy\TrashController as TrashStrategyController;
use App\Http\Controllers\v1\Strategy\UpdateController as UpdateStrategyController;
use App\Http\Controllers\v1\TradeLog\DestroyController as DestroyTradeLogController;
use App\Http\Controllers\v1\TradeLog\ListController as ListTradeLogController;
use App\Http\Controllers\v1\TradeLog\RestoreController as RestoreTradeLogController;
use App\Http\Controllers\v1\TradeLog\ShowController as ShowTradeLogController;
use App\Http\Controllers\v1\TradeLog\StoreController as StoreTradeLogController;
use App\Http\Controllers\v1\TradeLog\TrashController as TrashTradeLogController;
use App\Http\Controllers\v1\TradeLog\UpdateController as UpdateTradeLogController;
use App\Http\Controllers\v1\User\LoginController;
use App\Http\Controllers\v1\User\LogoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('user/login', LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('user/logout', LogoutController::class);

        Route::prefix('portfolios')->group(function () {
            Route::get('/', ListPortfolioController::class);
            Route::post('/', StorePortfolioController::class);
            Route::get('/{portfolio}', ShowPortfolioController::class);
            Route::put('/{portfolio}', UpdatePortfolioController::class);
            Route::delete('/{portfolio}/trash', TrashPortfolioController::class);
            Route::patch('/{portfolio}', RestorePortfolioController::class)->withTrashed();
            Route::delete('/{portfolio}/destroy', DestroyPortfolioController::class);
        });

        Route::prefix('strategies')->group(function () {
            Route::get('/', ListStrategyController::class);
            Route::post('/', StoreStrategyController::class);
            Route::get('/{id}', ShowStrategyController::class);
            Route::put('/', UpdateStrategyController::class);
            Route::delete('/{id}/trash', TrashStrategyController::class);
            Route::patch('/{id}', RestoreStrategyController::class);
            Route::delete('/{id}/destroy', DestroyStrategyController::class);
        });

        Route::prefix('cash-flows')->group(function () {
            Route::get('/', ListCashFlowController::class);
            Route::post('/', StoreCashFlowController::class);
            Route::get('/{id}', ShowCashFlowController::class);
            Route::put('/', UpdateCashFlowController::class);
            Route::delete('/{id}/trash', TrashCashFlowController::class);
            Route::patch('/{id}', RestoreCashFlowController::class);
            Route::delete('/{id}/destroy', DestroyCashFlowController::class);
        });

        Route::prefix('dividends')->group(function () {
            Route::get('/', ListDividendController::class);
            Route::get('/{id}', ShowDividendController::class);
            Route::post('/', StoreDividendController::class);
            Route::put('/', UpdateDividendController::class);
            Route::delete('/{id}/trash', TrashDividendController::class);
            Route::patch('/{id}', RestoreDividendController::class);
            Route::delete('/{id}/destroy', DestroyDividendController::class);
        });

        Route::prefix('trade-logs')->group(function () {
            Route::get('/', ListTradeLogController::class);
            Route::get('/{id}', ShowTradeLogController::class);
            Route::post('/', StoreTradeLogController::class);
            Route::put('/', UpdateTradeLogController::class);
            Route::delete('/{id}/trash', TrashTradeLogController::class);
            Route::patch('/{id}', RestoreTradeLogController::class);
            Route::delete('/{id}/destroy', DestroyTradeLogController::class);
        });

    });

});
