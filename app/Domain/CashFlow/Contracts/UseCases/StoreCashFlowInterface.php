<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Entities\CashFlow;

interface StoreCashFlowInterface
{
    public function handle(StoreCashFlowDTO $dto): CashFlow;
}
