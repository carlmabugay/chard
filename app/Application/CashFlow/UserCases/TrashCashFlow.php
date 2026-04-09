<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

class TrashCashFlow
{
    public function __construct(
        protected readonly CashFlowService $service
    ) {}

    public function handle(CashFlowModel $cash_flow): ?bool
    {
        return $this->service->trash($cash_flow);
    }
}
