<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\UpdateStrategyRequest;
use App\Http\Resources\Strategy\StrategyResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(UpdateStrategyRequest $request, StoreStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            $dto = StoreStrategyDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new StrategyResource($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
