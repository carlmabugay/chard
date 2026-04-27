<?php

namespace App\Domain\Portfolio\DTOs;

final class StorePortfolioDTO
{
    public function __construct(
        public int $user_id,
        public string $name,
    ) {}
}
