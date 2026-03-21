<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\UpdateCashFlowRequest;
use App\Http\Resources\CashFlow\CashFlowResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class UpdateController extends Controller
{
    public function __invoke(UpdateCashFlowRequest $request, StoreCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            $dto = StoreCashFlowDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return CashFlowResource::make($result);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
