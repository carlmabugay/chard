<?php

namespace App\Domain\Common\Pagination\Contracts;

interface PaginatedResultInterface
{
    public function toArray(): array;
}
