<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Domain\CashFlow\DTOs\UpdateCashFlowDTO;
use App\Domain\CashFlow\Process\UpdateCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\UpdateCashFlowRequest;
use App\Models\CashFlow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class UpdateController extends Controller
{
    public function __construct(
        protected readonly UpdateCashFlowProcess $process
    ) {}

    public function __invoke(CashFlow $cash_flow, UpdateCashFlowRequest $request): RedirectResponse
    {

        Gate::authorize('update', $cash_flow);

        $dto = new UpdateCashFlowDTO(
            id: $cash_flow->id,
            portfolio_id: $request->validated('portfolio_id'),
            type: $request->validated('type'),
            amount: $request->validated('amount'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('cash-flow.index')
            ->with('success', __('messages.success.updated', ['record' => 'Cash flow']));
    }
}
