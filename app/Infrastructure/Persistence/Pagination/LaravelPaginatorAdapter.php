<?php

namespace App\Infrastructure\Persistence\Pagination;

use App\Domain\Common\Pagination\PaginatedResult;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LaravelPaginatorAdapter
{
    public static function fromPaginator(LengthAwarePaginator $paginator, callable $mapper): PaginatedResult
    {
        return new PaginatedResult(
            data: collect($paginator->items())
                ->map($mapper)
                ->all(),

            pagination: [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),

                'links' => [
                    'first_page_url' => $paginator->url(1),
                    'last_page_url' => $paginator->url($paginator->lastPage()),
                    'next_page_url' => $paginator->url($paginator->nextPageUrl()),
                    'prev_page_url' => $paginator->url($paginator->previousPageUrl()),
                ],
            ]
        );
    }
}
