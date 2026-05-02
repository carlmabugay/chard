<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Domain\TradeLog\DTOs\DeleteTradeLogDTO;
use App\Domain\TradeLog\Process\DeleteTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeleteTradeLogProcess $process,
    ) {}

    public function __invoke(TradeLog $trade_log): JsonResponse
    {
        try {

            Gate::authorize('destroy', $trade_log);

            $dto = new DeleteTradeLogDTO(
                id: $trade_log->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.destroyed', ['record' => 'Trade log']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
