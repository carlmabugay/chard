<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Domain\Dividend\DTOs\RestoreDividendDTO;
use App\Domain\Dividend\Process\RestoreDividendProcess;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestoreDividendProcess $process
    ) {}

    public function __invoke(Dividend $dividend): RedirectResponse
    {

        Gate::authorize('restore', $dividend);

        $dto = new RestoreDividendDTO(
            id: $dividend->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('dividend.index')
            ->with('success', __('messages.success.restored', ['record' => 'Dividend']));
    }
}
