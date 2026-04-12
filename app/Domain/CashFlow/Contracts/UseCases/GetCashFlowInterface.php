<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

interface GetCashFlowInterface
{
    public function handle(CashFlowModel $cash_flow): CashFlow;
}
