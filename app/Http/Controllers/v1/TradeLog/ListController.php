<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use App\Domain\TradeLog\Process\ListTradeLogsProcess;
use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLogResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    public function __construct(
        protected readonly ListTradeLogsProcess $process
    ) {}

    public function __invoke(Request $request): JsonResource|JsonResponse
    {
        try {

            $dto = new ListTradeLogsDTO(
                search: $request->search,
                per_page: $request->per_page ?? 5,
                page: $request->page ?? 1,
                sort_by: $request->sort_by ?? 'created_at',
                sort_direction: $request->sort_direction ?? 'desc',
            );

            $result = $this->process->run(
                payload: $dto,
            );

            return TradeLogResource::collection($result)
                ->additional([
                    'success' => true,
                ]);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
