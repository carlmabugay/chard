<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Domain\Strategy\DTOs\UpdateStrategyDTO;
use App\Domain\Strategy\Processes\UpdateStrategyProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use App\Models\Strategy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class UpdateController extends Controller
{
    public function __construct(
        protected UpdateStrategyProcess $process
    ) {}

    public function __invoke(Strategy $strategy, StoreStrategyRequest $request): RedirectResponse
    {

        Gate::authorize('update', $strategy);

        $dto = new UpdateStrategyDTO(
            id: $strategy->id,
            name: $request->validated('name'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('strategy.index')
            ->with('success', __('messages.success.updated', ['record' => 'Strategy']));
    }
}
