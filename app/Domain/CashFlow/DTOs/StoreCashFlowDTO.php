<?php

namespace App\Domain\CashFlow\DTOs;

final class StoreCashFlowDTO
{
    public function __construct(
        public int $portfolio_id,
        public string $type,
        public int $amount,
    ) {}
}
