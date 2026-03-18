<?php

use App\Http\Controllers\v1\Portfolio\ListController as ListPortfolioController;
use App\Http\Controllers\v1\Portfolio\ShowController as ShowPortfolioController;
use App\Http\Controllers\v1\Portfolio\StoreController as StorePortfolioController;
use App\Http\Controllers\v1\Portfolio\UpdateController as UpdatePortfolioController;
use App\Http\Controllers\v1\Strategy\ListController as ListStrategyController;
use App\Http\Controllers\v1\Strategy\ShowController as ShowStrategyController;
use App\Http\Controllers\v1\Strategy\StoreController as StoreStrategyController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('portfolios', ListPortfolioController::class);
    Route::post('portfolios', StorePortfolioController::class);
    Route::get('portfolios/{id}', ShowPortfolioController::class);
    Route::put('portfolios', UpdatePortfolioController::class);

    Route::get('strategies', ListStrategyController::class);
    Route::post('strategies', StoreStrategyController::class);
    Route::get('strategies/{id}', ShowStrategyController::class);

})->middleware('auth:sanctum');
