<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Domain\TradeLog\Contracts\UseCases\ListTradeLogsInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLog\TradeLogCollection;
use App\Traits\HasPaginatedResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    use HasPaginatedResponse;

    public function __invoke(Request $request, ListTradeLogsInterface $use_case): JsonResource|JsonResponse
    {
        try {

            $result = $use_case->handle($this->prepareQueryCriteria($request));

            return $this->paginatedResponse(TradeLogCollection::make($result['data']), $result['pagination']);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
