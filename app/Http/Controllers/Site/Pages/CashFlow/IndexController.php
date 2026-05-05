<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use App\Domain\CashFlow\Process\ListCashFlowsProcess;
use App\Http\Controllers\Controller;
use App\Traits\HasDataTableResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class IndexController extends Controller
{
    use HasDataTableResponse;

    const array HEADERS = [
        ['label' => 'Type', 'key' => 'type'],
        ['label' => 'Amount', 'key' => 'amount'],
        ['label' => 'Date created', 'key' => 'created_at'],
    ];

    public function __construct(
        protected readonly ListCashFlowsProcess $process,
    ) {}

    public function __invoke(Request $request): Response
    {
        $dto = new ListCashFlowsDTO(
            search: $request->search,
            per_page: $request->per_page ?? 5,
            page: $request->page ?? 1,
            sort_by: $request->sort_by ?? 'created_at',
            sort_direction: $request->sort_direction ?? 'desc',
        );

        $cash_flows = $this->process->run(
            payload: $dto,
        );

        return Inertia::render('cash-flow/index', $this->dataTableResponse($cash_flows, self::HEADERS));
    }
}
