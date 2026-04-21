<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use App\Processes\StrategyCreationProcess;
use Illuminate\Support\Facades\Redirect;

final class StrategyController extends Controller
{
    public function __construct(
        private readonly StrategyCreationProcess $process,
    ) {}

    public function __invoke(StoreStrategyRequest $request)
    {

        $this->process->run(
            payload: $request->getPayload(),
        );

        return Redirect::route('strategy.index')->with('success', 'Strategy created.');
    }
}
