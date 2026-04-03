<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\UpdateTradeLogRequest;
use App\Http\Resources\TradeLog\TradeLogResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class UpdateController extends Controller
{
    public function __invoke(UpdateTradeLogRequest $request, StoreTradeLog $use_case): TradeLogResource|JsonResponse
    {
        try {

            $dto = StoreTradeLogDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return TradeLogResource::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
