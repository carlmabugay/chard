<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Application\Portolio\UseCases\StorePortfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\UpdatePortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(UpdatePortfolioRequest $request, StorePortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            $dto = StorePortfolioDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new PortfolioResource($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
