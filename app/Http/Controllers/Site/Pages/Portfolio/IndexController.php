<?php

namespace App\Http\Controllers\Site\Pages\Portfolio;

use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\Processes\ListPortfoliosProcess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __construct(
        protected readonly ListPortfoliosProcess $process,
    ) {}

    public function __invoke(Request $request)
    {

        $dto = new ListPortfoliosDTO(
            search: $request->search,
            per_page: $request->per_page ?? 10,
            page: $request->page ?? 1,
            sort_by: $request->sort_by ?? 'created_at',
            sort_direction: $request->sort_direction ?? 'desc',
        );

        $portfolios = $this->process->run(
            payload: $dto
        );

        return Inertia::render('portfolio/index', [
            'result' => $portfolios,
        ]);
    }
}
