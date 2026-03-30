<?php

namespace App\Traits;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait HasPaginatedResponse
{
    public function prepareQueryCriteria(Request $request): QueryCriteria
    {
        return new QueryCriteria(
            page: $request->query('page', 1),
            per_page: $request->query('per_page', 20),
            search: $request->query('search'),
            filters: $request->query('filters', []),
            sorts: $request->query('sorts') ?
            [
                new Sort(
                    field: data_get($request->query('sorts'), '0.field', null),
                    direction: data_get($request->query('sorts'), '0.direction', 'asc'),
                ),
            ] : []
        );
    }

    public function paginatedResponse(ResourceCollection $collection, array $pagination): ResourceCollection
    {
        return $collection->additional([
            'success' => true,
            'pagination' => $pagination,
        ]);
    }
}
