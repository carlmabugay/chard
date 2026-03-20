<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(int $id, GetCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return CashFlowResource::make($result);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
