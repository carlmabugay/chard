<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

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

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());

        }
    }
}
