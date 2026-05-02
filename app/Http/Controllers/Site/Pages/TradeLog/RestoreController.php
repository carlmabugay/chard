<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Domain\TradeLog\DTOs\RestoreTradeLogDTO;
use App\Domain\TradeLog\Process\RestoreTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestoreTradeLogProcess $process,
    ) {}

    public function __invoke(TradeLog $trade_log): RedirectResponse
    {

        Gate::authorize('restore', $trade_log);

        $dto = new RestoreTradeLogDTO(
            id: $trade_log->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('trade_log.index')
            ->with('success', __('messages.success.restored', ['record' => 'Trade log']));

    }
}
