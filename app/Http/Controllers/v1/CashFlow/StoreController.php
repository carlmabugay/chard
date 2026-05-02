<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Domain\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Process\StoreCashFlowProcess;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\CreateCashFlowRequest;
use App\Models\CashFlow;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class StoreController extends Controller
{
    public function __construct(
        protected readonly StoreCashFlowProcess $process
    ) {}

    public function __invoke(CreateCashFlowRequest $request): JsonResponse
    {
        try {

            $portfolioData = app(PortfolioRepository::class)->findById($request->validated('portfolio_id'));

            $portfolio = Portfolio::fromStdClass($portfolioData);

            Gate::authorize('store', [CashFlow::class, $portfolio]);

            $dto = new StoreCashFlowDTO(
                portfolio_id: $request->validated('portfolio_id'),
                type: $request->validated('type'),
                amount: $request->validated('amount'),
            );

            $this->process->run(
                payload: $dto
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.stored', ['record' => 'Cash flow']),
            ])->setStatusCode(201);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
