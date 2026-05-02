<?php

namespace App\Domain\TradeLog\DTOs;

final class UpdateTradeLogDTO
{
    public function __construct(
        public int $id,
        public int $portfolio_id,
        public string $symbol,
        public string $type,
        public float $price,
        public int $shares,
        public float $fees,
    ) {}
}
