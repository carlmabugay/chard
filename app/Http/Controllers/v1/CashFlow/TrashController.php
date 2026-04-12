<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Domain\CashFlow\Contracts\UseCases\TrashCashFlowInterface;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(CashFlow $cash_flow, TrashCashFlowInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('trash', $cash_flow);

            $result = $use_case->handle($cash_flow);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.trashed', ['record' => 'Cash flow']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
