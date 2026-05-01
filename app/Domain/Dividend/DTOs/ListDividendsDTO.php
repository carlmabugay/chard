<?php

namespace App\Domain\Dividend\DTOs;

final class ListDividendsDTO
{
    public function __construct(
        public ?string $search,
        public int $per_page,
        public int $page,
        public string $sort_by,
        public string $sort_direction,
    ) {}
}
