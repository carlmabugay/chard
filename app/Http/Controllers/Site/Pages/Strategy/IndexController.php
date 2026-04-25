<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Domain\Strategy\DTOs\ListStrategiesDTO;
use App\Domain\Strategy\Processes\ListStrategiesProcess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class IndexController extends Controller
{
    public function __construct(
        protected readonly ListStrategiesProcess $process,
    ) {}

    public function __invoke(Request $request): Response
    {
        $dto = new ListStrategiesDTO(
            search: $request->search,
            per_page: $request->per_page ?? 10,
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
