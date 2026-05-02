<?php

namespace App\Domain\TradeLog\DTOs;

final class DeleteTradeLogDTO
{
    public function __construct(
        public int $id,
    ) {}
}
