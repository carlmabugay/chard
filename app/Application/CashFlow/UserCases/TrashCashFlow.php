<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;

class TrashCashFlow
{
    public function __construct(
        protected readonly CashFlowService $service
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->trash($id);
    }
}
