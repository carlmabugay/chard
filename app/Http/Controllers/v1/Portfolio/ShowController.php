<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\UseCases\GetPortfolio;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

final class ShowController extends Controller
{
    public function __invoke(int $id, GetPortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {
            $result = $use_case->handle($id);

            return PortfolioResource::make($result);

        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'error' => 'Portfolio not found',
                'message' => sprintf('Portfolio with ID: %s not found', $id),
            ], 404);
        }
    }
}
