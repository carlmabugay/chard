<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\TrashCashFlowInterface;
use App\Models\CashFlow as CashFlowModel;

class TrashCashFlow implements TrashCashFlowInterface
{
    public function __construct(
        protected readonly CashFlowServiceInterface $service
    ) {}

    public function handle(CashFlowModel $cash_flow): ?bool
    {
        return $this->service->trash($cash_flow);
    }
}
