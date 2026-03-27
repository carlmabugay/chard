<?php

namespace App\Domain\Common\Pagination;

use App\Domain\Common\Pagination\Contracts\PaginatedResultInterface;

class PaginatedResult implements PaginatedResultInterface
{
    public function __construct(
        private readonly array $data,
        private readonly array $pagination,
    ) {}

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'pagination' => $this->pagination,
        ];
    }
}
