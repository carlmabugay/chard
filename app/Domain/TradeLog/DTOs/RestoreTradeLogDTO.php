<?php

namespace App\Domain\TradeLog\DTOs;

class RestoreTradeLogDTO
{
    public function __construct(
        public int $id,
    ) {}
}
