<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\UseCases\StoreCashFlowInterface;
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

            $request->merge(['id' => $cash_flow->id]);

            $dto = CashFlowDTO::fromRequest($request);

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
