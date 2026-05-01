<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Domain\Dividend\DTOs\DeleteDividendDTO;
use App\Domain\Dividend\Process\DeleteDividendProcess;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeleteDividendProcess $process
    ) {}

    public function __invoke(Dividend $dividend): RedirectResponse
    {
        Gate::authorize('destroy', $dividend);

        $dto = new DeleteDividendDTO(
            id: $dividend->id,
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('dividend.index')
            ->with('success', __('messages.success.destroyed', ['record' => 'Dividend']));
    }
}
