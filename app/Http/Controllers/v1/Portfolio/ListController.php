<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\Processes\ListPortfoliosProcess;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    public function __construct(
        protected readonly ListPortfoliosProcess $process,
    ) {}

    public function __invoke(Request $request): JsonResource|JsonResponse
    {
        try {

            $dto = new ListPortfoliosDTO(
                search: $request->search,
                per_page: $request->per_page ?? 5,
                page: $request->page ?? 1,
                sort_by: $request->sort_by ?? 'created_at',
                sort_direction: $request->sort_direction ?? 'desc',
            );

            $result = $this->process->run(
                payload: $dto
            );

            return PortfolioResource::collection($result)
                ->additional([
                    'success' => true,
                ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
