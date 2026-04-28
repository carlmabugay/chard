<?php

namespace App\Domain\Portfolio\DTOs;

final class DeletePortfolioDTO
{
    public function __construct(
        public int $id,
    ) {}
}
