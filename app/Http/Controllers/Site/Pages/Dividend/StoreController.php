<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Domain\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\Process\StoreDividendProcess;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class StoreController
{
    public function __construct(
        protected readonly StoreDividendProcess $process,
    ) {}

    public function __invoke(CreateDividendRequest $request): RedirectResponse
    {
        $portfolioData = app(PortfolioRepository::class)->findById($request->validated('portfolio_id'));

        $portfolio = Portfolio::fromStdClass($portfolioData);

        Gate::authorize('store', [Dividend::class, $portfolio]);

        $dto = new StoreDividendDTO(
            portfolio_id: $request->validated('portfolio_id'),
            symbol: $request->validated('symbol'),
            amount: $request->validated('amount'),
            // Todo: Bring back once date picker is applied.
            // $request->validated('recorded_at')
            recorded_at: now(),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('dividend.index')
            ->with('success', __('messages.success.stored', ['record' => 'Dividend']));
    }
}
