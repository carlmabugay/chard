<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Domain\Dividend\DTOs\ListDividendsDTO;
use App\Domain\Dividend\Process\ListDividendsProcess;
use App\Http\Controllers\Controller;
use App\Traits\HasDataTableResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class IndexController extends Controller
{
    use HasDataTableResponse;

    const array HEADERS = [
        ['label' => 'Name', 'key' => 'name'],
        ['label' => 'Symbol', 'key' => 'symbol'],
        ['label' => 'Amount', 'key' => 'amount'],
        ['label' => 'Date recorded', 'key' => 'recorded_at'],
    ];

    public function __construct(
        protected readonly ListDividendsProcess $process,
    ) {}

    public function __invoke(Request $request)
    {

        $dto = new ListDividendsDTO(
            search: $request->search,
            per_page: $request->per_page ?? 5,
            page: $request->page ?? 1,
            sort_by: $request->sort_by ?? 'created_at',
            sort_direction: $request->sort_direction ?? 'desc',
        );

        $dividends = $this->process->run(
            payload: $dto,
        );

        return Inertia::render('dividend/index', $this->dataTableResponse($dividends, self::HEADERS));
    }
}
