<?php

namespace App\Domain\Dividend\DTOs;

final class UpdateDividendDTO
{
    public function __construct(
        public int $id,
        public int $portfolio_id,
        public string $symbol,
        public float $amount,
        public string $recorded_at,
    ) {}
}
