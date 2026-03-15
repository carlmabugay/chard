<?php

use App\Http\Controllers\v1\Portfolio\ListController as PortfolioListController;
use App\Http\Controllers\v1\Portfolio\ShowPortfolioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('portfolios', PortfolioListController::class);
    Route::get('portfolios/{id}', ShowPortfolioController::class);

})->middleware('auth:sanctum');
