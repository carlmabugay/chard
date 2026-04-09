<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

class GetCashFlow
{
    public function handle(CashFlowModel $cash_flow): CashFlow
    {
        return CashFlow::fromEloquentModel($cash_flow);
    }
}
