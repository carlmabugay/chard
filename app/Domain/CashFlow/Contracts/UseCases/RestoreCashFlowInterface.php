<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Models\CashFlow as CashFlowModel;

interface RestoreCashFlowInterface
{
    public function handle(CashFlowModel $cash_flow): ?bool;
}
