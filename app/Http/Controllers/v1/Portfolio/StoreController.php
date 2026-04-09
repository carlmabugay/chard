<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Application\Portolio\UseCases\StorePortfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\CreatePortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreatePortfolioRequest $request, StorePortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            $dto = new StorePortfolioDTO(
                user_id: auth()->id(),
                name: $request->validated('name'),
            );

            $result = $use_case->handle($dto);

            return new PortfolioResource($result)->response()->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
