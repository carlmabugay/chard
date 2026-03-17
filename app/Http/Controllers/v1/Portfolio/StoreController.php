<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\DTOs\StorePortfolioDTO;
use App\Application\UseCases\StorePortfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePortfolioRequest;
use App\Http\Resources\PortfolioResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreatePortfolioRequest $request, StorePortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            $data = Arr::add($request->validated(), 'user_id', $request->user()->id);

            $dto = StorePortfolioDTO::fromArray($data);

            $result = $use_case->handle($dto);

            return new PortfolioResource($result)->response()->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());

        }

    }
}
