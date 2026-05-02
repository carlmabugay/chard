<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Domain\TradeLog\DTOs\DeleteTradeLogDTO;
use App\Domain\TradeLog\Process\DeleteTradeLogProcess;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeleteTradeLogProcess $process,
    ) {}

    public function __invoke(TradeLog $trade_log): RedirectResponse
    {

        Gate::authorize('destroy', $trade_log);

        $dto = new DeleteTradeLogDTO(
            id: $trade_log->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('trade_log.index')
            ->with('success', __('messages.success.destroyed', ['record' => 'Trade log']));
    }
}
