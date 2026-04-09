<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Portfolio $portfolio, GetPortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            $result = $use_case->handle($portfolio);

            return PortfolioResource::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
