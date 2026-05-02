<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Domain\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\Process\StoreDividendProcess;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Resources\DividendResource;
use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class StoreController extends Controller
{
    public function __construct(
        protected readonly StoreDividendProcess $process,
    ) {}

    public function __invoke(CreateDividendRequest $request): DividendResource|JsonResponse
    {
        try {

            $portfolioData = app(PortfolioRepository::class)->findById($request->validated('portfolio_id'));

            $portfolio = Portfolio::fromStdClass($portfolioData);

            Gate::authorize('store', [Dividend::class, $portfolio]);

            $dto = new StoreDividendDTO(
                portfolio_id: $request->validated('portfolio_id'),
                symbol: $request->validated('symbol'),
                amount: $request->validated('amount'),
                recorded_at: $request->validated('recorded_at'),
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.stored', ['record' => 'Dividend']),
            ])->setStatusCode(201);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
