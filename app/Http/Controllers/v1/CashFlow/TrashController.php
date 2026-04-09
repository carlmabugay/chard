<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(CashFlow $cash_flow, TrashCashFlow $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($cash_flow);

            return response()->json([
                'success' => $result,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
