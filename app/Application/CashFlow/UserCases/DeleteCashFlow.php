<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\DeleteCashFlowInterface;
use App\Models\CashFlow as CashFlowModel;

class DeleteCashFlow implements DeleteCashFlowInterface
{
    public function __construct(
        protected CashFlowServiceInterface $service
    ) {}

    public function handle(CashFlowModel $cash_flow): ?bool
    {
        return $this->service->delete($cash_flow);
    }
}
