<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Domain\Strategy\DTOs\CreateStrategyDTO;
use App\Domain\Strategy\Processes\CreateStrategyProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

final class StoreController extends Controller
{
    public function __construct(
        protected readonly CreateStrategyProcess $process,
    ) {}

    public function __invoke(StoreStrategyRequest $request): RedirectResponse
    {
        $dto = new CreateStrategyDTO(
            user_id: auth()->user()->id,
            name: $request->validated('name'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('strategy.index')
            ->with('success', __('messages.success.stored', ['record' => 'Strategy']));
    }
}
