<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\CreateTradeLogRequest;
use App\Http\Resources\TradeLog\TradeLogResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateTradeLogRequest $request, StoreTradeLog $use_case): TradeLogResource|JsonResponse
    {

        try {

            $dto = StoreTradeLogDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new TradeLogResource($result)->response()->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
