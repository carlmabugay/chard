<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\ListDividends;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dividend\DividendCollection;
use App\Traits\HasPaginatedResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListController extends Controller
{
    use HasPaginatedResponse;

    public function __invoke(Request $request, ListDividends $use_case): JsonResource|JsonResponse
    {
        try {

            $result = $use_case->handle($this->prepareQueryCriteria($request));

            return $this->paginatedResponse(DividendCollection::make($result['data']), $result['pagination']);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
