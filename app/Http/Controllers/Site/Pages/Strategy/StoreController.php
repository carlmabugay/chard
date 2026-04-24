<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use App\Domain\Strategy\Processes\StrategyCreationProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use Illuminate\Support\Facades\Redirect;

final class StoreController extends Controller
{
    public function __construct(
        private readonly StrategyCreationProcess $process,
    ) {}

    public function __invoke(StoreStrategyRequest $request)
    {
        $dto = new StrategyCreationDTO(
            user_id: auth()->user()->id,
            name: $request->validated('name'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('strategy.index')->with('success', 'Strategy created.');
    }
}
