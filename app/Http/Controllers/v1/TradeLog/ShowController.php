<?php

namespace App\Http\Controllers\V1\TradeLog;

use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLog\TradeLogResource;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(TradeLog $trade_log, GetTradeLog $use_case): TradeLogResource|JsonResponse
    {
        try {

            Gate::authorize('view', $trade_log);

            $result = $use_case->handle($trade_log);

            return TradeLogResource::make($result);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
