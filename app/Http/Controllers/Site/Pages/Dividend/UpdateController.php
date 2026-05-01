<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Domain\Dividend\DTOs\UpdateDividendDTO;
use App\Domain\Dividend\Process\UpdateDividendProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\UpdateDividendRequest;
use App\Models\Dividend;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class UpdateController extends Controller
{
    public function __construct(
        protected readonly UpdateDividendProcess $process,
    ) {}

    public function __invoke(Dividend $dividend, UpdateDividendRequest $request): RedirectResponse
    {
        Gate::authorize('update', $dividend);

        $dto = new UpdateDividendDTO(
            id: $dividend->id,
            portfolio_id: $request->validated('portfolio_id'),
            symbol: $request->validated('symbol'),
            amount: $request->validated('amount'),
            recorded_at: $request->validated('recorded_at'),
        );

        $this->process->run($dto);

        return Redirect::route('dividend.index')
            ->with('success', __('messages.success.updated', ['record' => 'Dividend']));
    }
}
