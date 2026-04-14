<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\UseCases\StoreTradeLogInterface;
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
    public function __invoke(TradeLog $trade_log, UpdateTradeLogRequest $request, StoreTradeLogInterface $use_case): TradeLogResource|JsonResponse
    {
        try {

            Gate::authorize('update', $trade_log);

            $request->merge(['id' => $trade_log->id]);

            $dto = TradeLogDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return TradeLogResource::make($result)->additional([
                'message' => __('messages.success.updated', ['record' => 'Trade log']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
