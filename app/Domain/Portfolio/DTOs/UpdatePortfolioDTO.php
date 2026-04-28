<?php

namespace App\Domain\Portfolio\DTOs;

final class UpdatePortfolioDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
