<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;

readonly class ListCashFlows
{
    public function __construct(
        private CashFlowService $service
    ) {
    }

    public function handle(): array
    {
        return $this->service->findAll();
    }
}
