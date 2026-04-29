<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\StoreTradeLogInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\CreateTradeLogRequest;
use App\Http\Resources\TradeLog\TradeLogResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateTradeLogRequest $request, StoreTradeLogInterface $use_case, PortfolioServiceInterface $portfolio_service): TradeLogResource|JsonResponse
    {

        try {

            $dto = TradeLogDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return TradeLogResource::make($result)
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
