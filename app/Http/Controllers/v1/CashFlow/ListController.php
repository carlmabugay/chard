<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListCashFlows $use_case): JsonResponse|CashFlowCollection
    {
        try {

            $result = $use_case->handle();

            return CashFlowCollection::make($result);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
