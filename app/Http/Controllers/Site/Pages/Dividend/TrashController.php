<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Domain\Dividend\DTOs\TrashDividendDTO;
use App\Domain\Dividend\Process\TrashDividendProcess;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class TrashController extends Controller
{
    public function __construct(
        protected readonly TrashDividendProcess $process,
    ) {}

    public function __invoke(Dividend $dividend): RedirectResponse
    {

        Gate::authorize('trash', $dividend);

        $dto = new TrashDividendDTO(
            id: $dividend->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('dividend.index')
            ->with('success', __('messages.success.trashed', ['record' => 'Dividend']));
    }
}
