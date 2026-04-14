<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\UseCases\TrashTradeLogInterface;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(TradeLog $trade_log, TrashTradeLogInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('trash', $trade_log);

            $dto = TradeLogDTO::fromModel($trade_log);

            $result = $use_case->handle($dto);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.trashed', ['record' => 'Trade log']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
