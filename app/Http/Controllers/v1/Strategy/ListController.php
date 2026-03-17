<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\UseCases\ListStrategies;
use App\Http\Controllers\Controller;
use App\Http\Resources\StrategyCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListStrategies $use_case): JsonResponse|StrategyCollection
    {
        try {

            $result = $use_case->handle();

            return StrategyCollection::make($result);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
