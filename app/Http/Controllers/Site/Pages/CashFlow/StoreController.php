<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Domain\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Process\StoreCashFlowProcess;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\CreateCashFlowRequest;
use App\Models\CashFlow;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class StoreController extends Controller
{
    public function __construct(
        protected readonly StoreCashFlowProcess $process
    ) {}

    public function __invoke(CreateCashFlowRequest $request): RedirectResponse
    {

        $portfolioData = app(PortfolioRepository::class)->findById($request->validated('portfolio_id'));

        $portfolio = Portfolio::fromStdClass($portfolioData);

        Gate::allows('store', [CashFlow::class, $portfolio]);

        $dto = new StoreCashFlowDTO(
            portfolio_id: $request->validated('portfolio_id'),
            type: $request->validated('type'),
            amount: $request->validated('amount'),
        );

        $this->process->run(
            payload: $dto
        );

        return Redirect::route('cash-flow.index')
            ->with('success', __('messages.success.stored', ['record' => 'Cash flow']));
    }
}
