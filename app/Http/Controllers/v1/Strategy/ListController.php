<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\ListStrategies;
use App\Http\Controllers\Controller;
use App\Http\Resources\Strategy\StrategyCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListStrategies $use_case): StrategyCollection|JsonResponse
    {
        try {

            $result = $use_case->handle();

            return StrategyCollection::make($result['data'])->additional([
                'success' => true,
                'pagination' => $result['pagination'],
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
