<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

class RestoreCashFlow
{
    public function __construct(
        protected CashFlowService $service,
    ) {}

    public function handle(CashFlowModel $cash_flow): ?bool
    {
        return $this->service->restore($cash_flow);
    }
}
