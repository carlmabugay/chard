<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\DTOs\StoreStrategyDTO;
use App\Application\UseCases\StoreStrategy;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStrategyRequest;
use App\Http\Resources\StrategyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Throwable;

class UpdateController extends Controller
{
    public function __invoke(UpdateStrategyRequest $request, StoreStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            $data = Arr::add($request->validated(), 'user_id', $request->user()->id);

            $dto = StoreStrategyDTO::fromArray($data);

            $result = $use_case->handle($dto);

            return new StrategyResource($result);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
