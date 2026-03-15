<?php

use App\Http\Controllers\v1\Portfolio\ListController as ListPortfolioController;
use App\Http\Controllers\v1\Portfolio\ShowController as ShowPortfolioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('portfolios', ListPortfolioController::class);
    Route::get('portfolios/{id}', ShowPortfolioController::class);

})->middleware('auth:sanctum');
