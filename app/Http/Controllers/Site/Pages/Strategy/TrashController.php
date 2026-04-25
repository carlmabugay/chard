<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Domain\Strategy\DTOs\TrashStrategyDTO;
use App\Domain\Strategy\Processes\TrashStrategyProcess;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class TrashController extends Controller
{
    public function __construct(
        protected readonly TrashStrategyProcess $process,
    ) {}

    public function __invoke(Strategy $strategy): RedirectResponse
    {

        Gate::authorize('trash', $strategy);

        $dto = new TrashStrategyDTO(
            id: $strategy->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('strategy.index')
            ->with('success', __('messages.success.trashed', ['record' => 'Strategy']));
    }
}
