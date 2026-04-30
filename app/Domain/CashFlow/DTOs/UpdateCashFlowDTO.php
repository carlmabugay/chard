<?php

namespace App\Domain\CashFlow\DTOs;

final class UpdateCashFlowDTO
{
    public function __construct(
        public int $id,
        public int $portfolio_id,
        public string $type,
        public int $amount,
    ) {}
}
