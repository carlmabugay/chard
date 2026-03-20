<?php

namespace App\Domain\CashFlow\Contracts\Write;

use App\Domain\CashFlow\Entities\CashFlow;

interface CashFlowWriteRepositoryInterface
{
    public function store(CashFlow $cash_flow): CashFlow;
}
