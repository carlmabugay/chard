<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Contracts\UseCases\StoreCashFlowInterface;
use App\Enums\CashFlowType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\UpdateCashFlowRequest;
use App\Http\Resources\CashFlow\CashFlowResource;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(CashFlow $cash_flow, UpdateCashFlowRequest $request, StoreCashFlowInterface $use_case): CashFlowResource|JsonResponse
    {
        try {

            Gate::authorize('update', $cash_flow);

            $dto = new StoreCashFlowDTO(
                portfolio_id: $request->validated('portfolio_id') ?? $cash_flow->portfolio->id,
                type: CashFlowType::fromInput($request->validated('type')),
                amount: $request->validated('amount'),
                id: $cash_flow->id,
            );

            $result = $use_case->handle($dto);

            return CashFlowResource::make($result)
                ->additional([
                    'message' => __('messages.success.updated', ['record' => 'Cash flow']),
                ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
