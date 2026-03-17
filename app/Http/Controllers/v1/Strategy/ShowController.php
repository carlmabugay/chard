<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\UseCases\GetStrategy;
use App\Http\Controllers\Controller;
use App\Http\Resources\StrategyResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class ShowController extends Controller
{
    public function __invoke(int $id, GetStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return StrategyResource::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());

        }
    }
}
