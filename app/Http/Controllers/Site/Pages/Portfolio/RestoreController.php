<?php

namespace App\Http\Controllers\Site\Pages\Portfolio;

use App\Domain\Portfolio\DTOs\RestorePortfolioDTO;
use App\Domain\Portfolio\Processes\RestorePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestorePortfolioProcess $process,
    ) {}

    public function __invoke(Portfolio $portfolio): RedirectResponse
    {
        Gate::authorize('restore', $portfolio);

        $dto = new RestorePortfolioDTO(
            id: $portfolio->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('portfolio.index')
            ->with('success', __('messages.success.restored', ['record' => 'Portfolio']));
    }
}
