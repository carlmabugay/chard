<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\Contracts\UseCases\StoreTradeLogInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\CreateTradeLogRequest;
use App\Http\Resources\TradeLog\TradeLogResource;
use App\Models\Portfolio;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateTradeLogRequest $request, StoreTradeLogInterface $use_case): TradeLogResource|JsonResponse
    {

        try {

            // TODO: Use service here.
            $portfolio = Portfolio::find($request->validated('portfolio_id'));

            Gate::authorize('store', [TradeLog::class, $portfolio]);

            $dto = StoreTradeLogDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new TradeLogResource($result)
                ->additional([
                    'message' => __('messages.success.stored', ['record' => 'Trade log']),
                ])
                ->response()
                ->setStatusCode(201);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
