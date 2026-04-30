<?php

namespace App\Domain\CashFlow\DTOs;

final class RestoreCashFlowDTO
{
    public function __construct(
        public int $id,
    ) {}
}
