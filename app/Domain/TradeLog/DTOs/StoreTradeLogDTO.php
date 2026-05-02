<?php

namespace App\Domain\TradeLog\DTOs;

class StoreTradeLogDTO
{
    public function __construct(
        public int $portfolio_id,
        public string $symbol,
        public string $type,
        public float $price,
        public int $shares,
        public float $fees,
    ) {}
}
