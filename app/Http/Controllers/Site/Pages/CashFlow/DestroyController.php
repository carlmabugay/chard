<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Domain\CashFlow\DTOs\DeleteCashFlowDTO;
use App\Domain\CashFlow\Process\DeleteCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeleteCashFlowProcess $process
    ) {}

    public function __invoke(CashFlow $cash_flow): RedirectResponse
    {

        Gate::authorize('destroy', $cash_flow);

        $dto = new DeleteCashFlowDTO(
            id: $cash_flow->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('cash-flow.index')
            ->with('success', __('messages.success.destroyed', ['record' => 'Cash flow']));
    }
}
