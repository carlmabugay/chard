<?php

namespace App\Domain\Portfolio\DTOs;

final class ListPortfoliosDTO
{
    public function __construct(
        public ?string $search,
        public int $per_page,
        public int $page,
        public string $sort_by,
        public string $sort_direction,
    ) {}
}
