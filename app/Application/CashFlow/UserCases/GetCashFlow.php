<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Contracts\UseCases\GetCashFlowInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

class GetCashFlow implements GetCashFlowInterface
{
    public function handle(CashFlowModel $cash_flow): CashFlow
    {
        return CashFlow::fromEloquentModel($cash_flow);
    }
}
