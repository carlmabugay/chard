<?php

namespace App\Domain\CashFlow\Contracts\Write;

use App\Domain\CashFlow\Entities\CashFlow;

interface CashFlowWriteRepositoryInterface
{
    public function store(CashFlow $cash_flow): CashFlow;

    public function trash(int $id): ?bool;

    public function restore(int $id): ?bool;
}
