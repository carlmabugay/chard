<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowResource;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(CashFlow $cash_flow, GetCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            Gate::authorize('view', $cash_flow);

            $result = $use_case->handle($cash_flow);

            return CashFlowResource::make($result);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
