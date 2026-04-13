<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Application\CashFlow\DTOs\CashFlowDTO;

interface DeleteCashFlowInterface
{
    public function handle(CashFlowDTO $dto): ?bool;
}
