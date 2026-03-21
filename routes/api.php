<?php

use App\Http\Controllers\v1\CashFlow\ListController as ListCashFlowController;
use App\Http\Controllers\v1\CashFlow\ShowController as ShowCashFlowController;
use App\Http\Controllers\v1\CashFlow\StoreController as StoreCashFlowController;
use App\Http\Controllers\v1\CashFlow\UpdateController as UpdateCashFlowController;
use App\Http\Controllers\v1\Portfolio\ListController as ListPortfolioController;
use App\Http\Controllers\v1\Portfolio\ShowController as ShowPortfolioController;
use App\Http\Controllers\v1\Portfolio\StoreController as StorePortfolioController;
use App\Http\Controllers\v1\Portfolio\UpdateController as UpdatePortfolioController;
use App\Http\Controllers\v1\Strategy\ListController as ListStrategyController;
use App\Http\Controllers\v1\Strategy\ShowController as ShowStrategyController;
use App\Http\Controllers\v1\Strategy\StoreController as StoreStrategyController;
use App\Http\Controllers\v1\Strategy\UpdateController as UpdateStrategyController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('portfolios')->group(function () {
        Route::get('/', ListPortfolioController::class);
        Route::post('/', StorePortfolioController::class);
        Route::get('/{id}', ShowPortfolioController::class);
        Route::put('/', UpdatePortfolioController::class);
    });

    Route::prefix('strategies')->group(function () {
        Route::get('/', ListStrategyController::class);
        Route::post('/', StoreStrategyController::class);
        Route::get('/{id}', ShowStrategyController::class);
        Route::put('/', UpdateStrategyController::class);
    });

    Route::prefix('cashflows')->group(function () {
        Route::get('/', ListCashFlowController::class);
        Route::post('/', StoreCashFlowController::class);
        Route::get('/{id}', ShowCashFlowController::class);
        Route::put('/', UpdateCashFlowController::class);
    });

})->middleware('auth:sanctum');
