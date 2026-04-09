<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(TradeLog $trade_log, TrashTradeLog $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($trade_log);

            return response()->json([
                'success' => $result,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
