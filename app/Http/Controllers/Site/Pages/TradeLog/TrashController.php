<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Domain\TradeLog\DTOs\TrashTradeLogDTO;
use App\Domain\TradeLog\Process\TrashTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class TrashController extends Controller
{
    public function __construct(
        protected readonly TrashTradeLogProcess $process
    ) {}

    public function __invoke(TradeLog $trade_log): RedirectResponse
    {

        Gate::authorize('trash', $trade_log);

        $dto = new TrashTradeLogDTO(
            id: $trade_log->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('trade_log.index')
            ->with('success', __('messages.success.trashed', ['record' => 'Trade log']));
    }
}
