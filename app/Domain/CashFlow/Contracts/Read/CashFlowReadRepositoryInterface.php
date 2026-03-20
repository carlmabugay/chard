<?php

namespace App\Domain\CashFlow\Contracts\Read;

use App\Domain\CashFlow\Entities\CashFlow;

interface CashFlowReadRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): CashFlow;
}
