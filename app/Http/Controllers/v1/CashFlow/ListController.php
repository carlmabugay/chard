<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Domain\CashFlow\Contracts\UseCases\ListCashFlowsInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowCollection;
use App\Traits\HasPaginatedResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    use HasPaginatedResponse;

    public function __invoke(Request $request, ListCashFlowsInterface $use_case): JsonResource|JsonResponse
    {
        try {

            $result = $use_case->handle($this->prepareQueryCriteria($request));

            return $this->paginatedResponse(CashFlowCollection::make($result['data']), $result['pagination']);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
