<?php

namespace App\Domain\Strategy\DTOs;

final class ListStrategiesDTO
{
    public function __construct(
        public ?string $search,
        public int $per_page,
        public int $page,
        public string $sort_by,
        public string $sort_direction,
    ) {}

}
