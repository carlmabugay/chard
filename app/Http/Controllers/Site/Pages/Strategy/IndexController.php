<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use App\Domain\Strategy\Processes\StrategyCollectionProcess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class IndexController extends Controller
{
    public function __construct(
        private readonly StrategyCollectionProcess $process,
    ) {}

    public function __invoke(Request $request)
    {
        $dto = new StrategyCollectionDTO(
            search: $request->search,
            per_page: $request->per_page ?? 5,
            page: $request->page ?? 1,
            sort_by: $request->sort_by ?? 'created_at',
            sort_direction: $request->sort_direction ?? 'desc',
        );

        $strategies = $this->process->run(
            payload: $dto
        );

        return Inertia::render('strategy/index', [
            'result' => $strategies,
        ]);
    }
}
