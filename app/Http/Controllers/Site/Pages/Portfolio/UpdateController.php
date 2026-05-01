<?php

namespace App\Http\Controllers\Site\Pages\Portfolio;

use App\Domain\Portfolio\DTOs\UpdatePortfolioDTO;
use App\Domain\Portfolio\Processes\UpdatePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class UpdateController extends Controller
{
    public function __construct(
        protected UpdatePortfolioProcess $process,
    ) {}

    public function __invoke(Portfolio $portfolio, StorePortfolioRequest $request): RedirectResponse
    {
        Gate::authorize('update', $portfolio);

        $dto = new UpdatePortfolioDTO(
            id: $portfolio->id,
            name: $request->validated('name'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('portfolio.index')
            ->with('success', __('messages.success.updated', ['record' => 'Portfolio']));
    }
}
