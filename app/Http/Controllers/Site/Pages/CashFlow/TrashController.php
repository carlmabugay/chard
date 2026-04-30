<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Domain\CashFlow\DTOs\TrashCashFlowDTO;
use App\Domain\CashFlow\Process\TrashCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class TrashController extends Controller
{
    public function __construct(
        protected TrashCashFlowProcess $process,
    ) {}

    public function __invoke(CashFlow $cash_flow)
    {

        Gate::authorize('trash', $cash_flow);

        $dto = new TrashCashFlowDTO(
            id: $cash_flow->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('cash-flow.index')
            ->with('success', __('messages.success.trashed', ['record' => 'Cash flow']));
    }
}
