<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use App\Domain\TradeLog\Process\ListTradeLogsProcess;
use App\Http\Controllers\Controller;
use App\Traits\HasDataTableResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class IndexController extends Controller
{
    use HasDataTableResponse;

    const array HEADERS = [
        ['label' => 'Name', 'key' => 'name'],
        ['label' => 'Type', 'key' => 'type'],
        ['label' => 'Symbol', 'key' => 'symbol'],
        ['label' => 'Price', 'key' => 'price'],
        ['label' => 'Shares', 'key' => 'shares'],
        ['label' => 'Fees', 'key' => 'fees'],
        ['label' => 'Date recorded', 'key' => 'recorded_at'],
    ];

    public function __construct(
        protected readonly ListTradeLogsProcess $process,
    ) {}

    public function __invoke(Request $request): Response
    {
        $dto = new ListTradeLogsDTO(
            search: $request->search,
            per_page: $request->per_page ?? 10,
            page: $request->page ?? 1,
            sort_by: $request->sort_by ?? 'created_at',
            sort_direction: $request->sort_direction ?? 'desc',
        );

        $trade_logs = $this->process->run(
            payload: $dto,
        );

        return Inertia::render('trade-log/index', $this->dataTableResponse($trade_logs, self::HEADERS));
    }
}
