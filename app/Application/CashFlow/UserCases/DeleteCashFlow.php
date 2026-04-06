<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;

class DeleteCashFlow
{
    public function __construct(
        protected CashFlowService $service
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->delete($id);
    }
}
