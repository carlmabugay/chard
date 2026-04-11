<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\Contracts\ListStrategiesInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Strategy\StrategyCollection;
use App\Traits\HasPaginatedResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    use HasPaginatedResponse;

    public function __invoke(Request $request, ListStrategiesInterface $use_case): JsonResource|JsonResponse
    {
        try {

            $result = $use_case->handle($this->prepareQueryCriteria($request));

            return $this->paginatedResponse(StrategyCollection::make($result['data']), $result['pagination']);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
