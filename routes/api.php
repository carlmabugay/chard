<?php

use App\Http\Controllers\v1\Portfolio\ListController as PortfolioListController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('portfolios', PortfolioListController::class);

})->middleware('auth:sanctum');
