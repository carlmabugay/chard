<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use App\Domain\Strategy\Processes\StrategyCollectionProcess;
use App\Http\Controllers\Controller;
use App\Http\Resources\StrategyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    public function __construct(
        private readonly StrategyCollectionProcess $process,
    ) {}

    public function __invoke(Request $request): JsonResource|JsonResponse
    {
        try {

            $dto = new StrategyCollectionDTO(
                search: $request->search,
                per_page: $request->per_page ?? 5,
                page: $request->page ?? 1,
                sort_by: $request->sort_by ?? 'created_at',
                sort_direction: $request->sort_direction ?? 'desc',
            );

            $result = $this->process->run(
                payload: $dto
            );

            return StrategyResource::collection($result)->additional([
                'success' => true,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
