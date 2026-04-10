<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\DeleteCashFlow;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __invoke(CashFlow $cash_flow, DeleteCashFlow $use_case): JsonResponse
    {
        try {

            Gate::authorize('destroy', $cash_flow);

            $result = $use_case->handle($cash_flow);

            return response()->json([
                'success' => $result,
            ]);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
