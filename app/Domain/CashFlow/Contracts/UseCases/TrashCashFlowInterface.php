<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Application\CashFlow\DTOs\CashFlowDTO;

interface TrashCashFlowInterface
{
    public function handle(CashFlowDTO $dto): ?bool;
}
