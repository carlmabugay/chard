<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\CreateCashFlowRequest;
use App\Http\Resources\CashFlow\CashFlowResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateCashFlowRequest $request, StoreCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            $dto = StoreCashFlowDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new CashFlowResource($result)->response()->setStatusCode(201);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
