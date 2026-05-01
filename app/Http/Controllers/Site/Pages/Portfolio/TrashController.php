<?php

namespace App\Http\Controllers\Site\Pages\Portfolio;

use App\Domain\Portfolio\DTOs\TrashPortfolioDTO;
use App\Domain\Portfolio\Processes\TrashPortfolioProcess;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class TrashController extends Controller
{
    public function __construct(
        protected TrashPortfolioProcess $process
    ) {}

    public function __invoke(Portfolio $portfolio): RedirectResponse
    {
        Gate::authorize('trash', $portfolio);

        $dto = new TrashPortfolioDTO(
            id: $portfolio->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('portfolio.index')
            ->with('success', __('messages.success.trashed', ['record' => 'Portfolio']));
    }
}
