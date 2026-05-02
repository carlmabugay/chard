<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Domain\TradeLog\DTOs\UpdateTradeLogDTO;
use App\Domain\TradeLog\Process\UpdateTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeLog\UpdateTradeLogRequest;
use App\Models\TradeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class UpdateController extends Controller
{
    public function __construct(
        protected readonly UpdateTradeLogProcess $process,
    ) {}

    public function __invoke(TradeLog $trade_log, UpdateTradeLogRequest $request): RedirectResponse
    {
        Gate::authorize('update', $trade_log);

        $dto = new UpdateTradeLogDTO(
            id: $trade_log->id,
            portfolio_id: $request->validated('portfolio_id'),
            symbol: $request->validated('symbol'),
            type: $request->validated('type'),
            price: $request->validated('price'),
            shares: $request->validated('shares'),
            fees: $request->validated('fees'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('trade_log.index')
            ->with('success', __('messages.success.updated', ['record' => 'Trade log']));

    }
}
