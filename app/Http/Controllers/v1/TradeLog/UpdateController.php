<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Domain\TradeLog\DTOs\UpdateTradeLogDTO;
use App\Domain\TradeLog\Process\UpdateTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\UpdateTradeLogRequest;
use App\Http\Resources\TradeLogResource;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __construct(
        protected readonly UpdateTradeLogProcess $process,
    ) {}

    public function __invoke(TradeLog $trade_log, UpdateTradeLogRequest $request): TradeLogResource|JsonResponse
    {
        try {

            Gate::authorize('update', $trade_log);

            $dto = new UpdateTradeLogDTO(
                id: $trade_log->id,
                portfolio_id: $request->validated('portfolio_id'),
                symbol: $request->validated('symbol'),
                type: $request->validated('type'),
                price: $request->validated('price'),
                shares: $request->validated('shares'),
                fees: $request->validated('fees'),
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.updated', ['record' => 'Trade log']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
