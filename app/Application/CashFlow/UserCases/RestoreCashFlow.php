<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\RestoreCashFlowInterface;
use App\Models\CashFlow as CashFlowModel;

class RestoreCashFlow implements RestoreCashFlowInterface
{
    public function __construct(
        protected CashFlowServiceInterface $service,
    ) {}

    public function handle(CashFlowModel $cash_flow): ?bool
    {
        return $this->service->restore($cash_flow);
    }
}
