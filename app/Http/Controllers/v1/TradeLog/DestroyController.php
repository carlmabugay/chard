<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Domain\TradeLog\Contracts\UseCases\DeleteTradeLogInterface;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __invoke(TradeLog $trade_log, DeleteTradeLogInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('destroy', $trade_log);

            $result = $use_case->handle($trade_log);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.destroyed', ['record' => 'Trade log']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
