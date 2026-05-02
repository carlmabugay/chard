<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Domain\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\Process\StoreTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\CreateTradeLogRequest;
use App\Models\Portfolio;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class StoreController extends Controller
{
    public function __construct(
        protected readonly StoreTradeLogProcess $process,
    ) {}

    public function __invoke(CreateTradeLogRequest $request): JsonResponse
    {
        try {

            $portfolioData = app(PortfolioRepository::class)->findById($request->validated('portfolio_id'));

            $portfolio = Portfolio::fromStdClass($portfolioData);

            Gate::authorize('store', [TradeLog::class, $portfolio]);

            $dto = new StoreTradeLogDTO(
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
                'message' => __('messages.success.stored', ['record' => 'Trade log']),
            ])->setStatusCode(201);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
