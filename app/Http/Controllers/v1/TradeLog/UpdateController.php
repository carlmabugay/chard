<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\UpdateTradeLogRequest;
use App\Http\Resources\TradeLog\TradeLogResource;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(TradeLog $trade_log, UpdateTradeLogRequest $request, StoreTradeLog $use_case): TradeLogResource|JsonResponse
    {
        try {

            Gate::authorize('update', $trade_log);

            $dto = new StoreTradeLogDTO(
                portfolio_id: $request->validated('portfolio_id'),
                symbol: $request->validated('symbol'),
                type: $request->validated('type'),
                price: $request->validated('price'),
                shares: $request->validated('shares'),
                fees: $request->validated('fees'),
                id: $trade_log->id,
            );

            $result = $use_case->handle($dto);

            return TradeLogResource::make($result)->additional([
                'message' => __('messages.success.updated', ['record' => 'Trade log']),
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
