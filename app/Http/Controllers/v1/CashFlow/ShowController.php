<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowResource;
use App\Models\CashFlow;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(CashFlow $cash_flow, GetCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            $result = $use_case->handle($cash_flow);

            return CashFlowResource::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
