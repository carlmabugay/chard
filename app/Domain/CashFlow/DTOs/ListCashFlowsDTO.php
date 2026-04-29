<?php

namespace App\Domain\CashFlow\DTOs;

final class ListCashFlowsDTO
{
    public function __construct(
        public ?string $search,
        public int $per_page,
        public int $page,
        public string $sort_by,
        public string $sort_direction,
    ) {}
}
