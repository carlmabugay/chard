<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\UseCases\ListPortfolios;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioCollection;

final class ListController extends Controller
{
    public function __invoke(ListPortfolios $useCase): PortfolioCollection
    {

        $result = $useCase->handle();

        return new PortfolioCollection($result);
    }
}
