<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\UseCases\GetPortfolio;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;

class ShowController extends Controller
{
    public function __invoke(int $id, GetPortfolio $use_case): PortfolioResource
    {
        $result = $use_case->handle($id);

        return PortfolioResource::make($result);
    }
}
