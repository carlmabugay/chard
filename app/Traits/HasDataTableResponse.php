<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait HasDataTableResponse
{
    public function dataTableResponse(LengthAwarePaginator $paginator, array $headers = []): array
    {
        return [
            'headers' => $headers,
            'items' => $paginator->items(),
            'pagination' => [
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
            ],
        ];
    }
}
