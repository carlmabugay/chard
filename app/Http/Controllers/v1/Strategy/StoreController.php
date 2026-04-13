<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\UseCases\StoreStrategyInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use App\Http\Resources\Strategy\StrategyResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(StoreStrategyRequest $request, StoreStrategyInterface $use_case): StrategyResource|JsonResponse
    {
        try {

            $dto = StrategyDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return new StrategyResource($result)
                ->additional([
                    'message' => __('messages.success.stored', ['record' => 'Strategy']),
                ])
                ->response()
                ->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
