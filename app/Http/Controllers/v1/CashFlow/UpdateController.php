<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Enums\CashFlowType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\UpdateCashFlowRequest;
use App\Http\Resources\CashFlow\CashFlowResource;
use App\Models\CashFlow;
use Illuminate\Http\JsonResponse;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(CashFlow $cash_flow, UpdateCashFlowRequest $request, StoreCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            $dto = new StoreCashFlowDTO(
                portfolio_id: $cash_flow->portfolio->id,
                type: CashFlowType::fromInput($request->validated('type')),
                amount: $request->validated('amount'),
                id: $cash_flow->id,
            );

            $result = $use_case->handle($dto);

            return CashFlowResource::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
