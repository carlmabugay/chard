<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Domain\CashFlow\DTOs\RestoreCashFlowDTO;
use App\Domain\CashFlow\Process\RestoreCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestoreCashFlowProcess $process,
    ) {}

    public function __invoke(CashFlow $cash_flow): RedirectResponse
    {
        Gate::authorize('restore', $cash_flow);

        $dto = new RestoreCashFlowDTO(
            id: $cash_flow->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('cash_flow.index')
            ->with('success', __('messages.success.restored', ['record' => 'Cash flow']));
    }
}
