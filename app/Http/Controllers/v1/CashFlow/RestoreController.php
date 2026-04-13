<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\UseCases\RestoreCashFlowInterface;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(CashFlow $cash_flow, RestoreCashFlowInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('restore', $cash_flow);

            $dto = CashFlowDTO::fromModel($cash_flow);

            $result = $use_case->handle($dto);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.restored', ['record' => 'Cash flow']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
