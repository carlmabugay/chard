<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\CreateStrategyRequest;
use App\Http\Resources\Strategy\StrategyResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateStrategyRequest $request, StoreStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            $dto = StoreStrategyDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new StrategyResource($result)->response()->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());

        }
    }
}
