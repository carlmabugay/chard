<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Domain\Common\Query\QueryCriteria;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListCashFlows $use_case): JsonResponse|CashFlowCollection
    {
        try {

            $criteria = new QueryCriteria(
                page: request('page', 1),
                per_page: request('per_page', 15),

                search: request('search'),
            );

            $result = $use_case->handle($criteria);

            return CashFlowCollection::make($result['data'])->additional([
                'success' => true,
                'pagination' => $result['pagination'],
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
