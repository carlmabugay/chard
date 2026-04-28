<?php

namespace App\Domain\Portfolio\DTOs;

final class RestorePortfolioDTO
{
    public function __construct(
        public int $id,
    ) {}

}
