<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Models\CashFlow as CashFlowModel;

interface TrashCashFlowInterface
{
    public function handle(CashFlowModel $cash_flow): ?bool;
}
