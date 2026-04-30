<?php

namespace App\Domain\CashFlow\DTOs;

final class DeleteCashFlowDTO
{
    public function __construct(
        public int $id,
    ) {}
}
