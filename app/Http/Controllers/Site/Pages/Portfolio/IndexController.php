<?php

namespace App\Http\Controllers\Site\Pages\Portfolio;

use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\Processes\ListPortfoliosProcess;
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
        ['label' => 'Date created', 'key' => 'created_at'],
        ['label' => 'Date updated', 'key' => 'updated_at'],
    ];

    public function __construct(
        protected readonly ListPortfoliosProcess $process,
    ) {}

    public function __invoke(Request $request): Response
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

        return Inertia::render('portfolio/index', $this->dataTableResponse($portfolios, self::HEADERS));
    }
}
