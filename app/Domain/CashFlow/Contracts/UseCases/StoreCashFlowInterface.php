<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Entities\CashFlow;

interface StoreCashFlowInterface
{
    public function handle(CashFlowDTO $dto): CashFlow;
}
