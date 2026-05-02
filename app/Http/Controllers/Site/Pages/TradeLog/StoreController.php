<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Domain\CashFlow\Process\StoreCashFlowProcess;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Domain\TradeLog\DTOs\StoreTradeLogDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\CreateCashFlowRequest;
use App\Models\Portfolio;
use App\Models\TradeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class StoreController extends Controller
{
    public function __construct(
        protected readonly StoreCashFlowProcess $process
    ) {}

    public function __invoke(CreateCashFlowRequest $request): RedirectResponse
    {

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

        return Redirect::route('trade_log.index')
            ->with('success', __('messages.success.stored', ['record' => 'Trade log']));
    }
}
